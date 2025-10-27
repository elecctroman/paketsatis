<?php

namespace App\Controllers\Frontend;

use Core\Controller;
use Core\Response;
use Core\Request;
use Core\Validator;
use Core\Security;
use App\Models\Order;
use App\Models\Service;
use App\Services\Payment\IyzicoClient;
use App\Services\Payment\PayTRClient;

class CheckoutController extends Controller
{
    public function show(): Response
    {
        $services = (new Service())->all();
        $content = $this->view->render('public.checkout', [
            'services' => $services,
            'csrf' => Security::csrfToken(),
        ]);
        return new Response($content);
    }

    public function process(Request $request): Response
    {
        $data = $request->all();
        $validator = new Validator($data, [
            'service_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'email' => 'required|email',
            'payment_method' => 'required|in:iyzico,paytr'
        ]);
        if ($validator->fails() || !Security::verifyCsrf($data['_token'] ?? null)) {
            return new Response('Invalid input', 422);
        }
        $service = (new Service())->find($data['service_id']);
        if (!$service) {
            return new Response('Service not found', 404);
        }
        $quantity = (int) $data['quantity'];
        $unitPrice = (float) $service['price_per_1000'] / 1000;
        $subtotal = $unitPrice * $quantity;
        $discount = 0.0;
        if (!empty($data['coupon'])) {
            $coupon = $this->findCoupon($data['coupon']);
            if ($coupon) {
                $discount = $coupon['type'] === 'percent' ? ($subtotal * ((float) $coupon['value'] / 100)) : (float) $coupon['value'];
            }
        }
        $total = max($subtotal - $discount, 0);
        $orderId = (new Order())->create([
            'user_id' => null,
            'service_id' => $service['id'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
            'coupon_id' => $coupon['id'] ?? null,
            'discount_total' => $discount,
            'total' => $total,
            'currency' => 'TRY',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $payload = ['order_id' => $orderId, 'amount' => $total, 'email' => $data['email']];
        $payment = $data['payment_method'] === 'iyzico' ? (new IyzicoClient())->initiate($payload) : (new PayTRClient())->initiate($payload);
        return new Response(json_encode(['success' => true, 'redirect' => $payment['redirect_url']]), 200, ['Content-Type' => 'application/json']);
    }

    private function findCoupon(string $code): ?array
    {
        $stmt = \Core\DB::query('SELECT * FROM coupons WHERE code = :code AND is_active = 1 LIMIT 1', ['code' => $code]);
        $coupon = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($coupon && strtotime($coupon['starts_at']) <= time() && strtotime($coupon['ends_at']) >= time()) {
            return $coupon;
        }
        return null;
    }
}

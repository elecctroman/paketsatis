<?php

namespace App\Controllers\Frontend;

use Core\Controller;
use Core\Response;
use Core\Request;
use Core\Validator;
use Core\Security;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function show(): Response
    {
        $content = $this->view->render('public.order_track', [
            'title' => 'Sipariş Takip',
            'csrf' => Security::csrfToken(),
            'result' => null,
            'errors' => [],
        ]);
        return new Response($content);
    }

    public function search(Request $request): Response
    {
        $data = $request->all();
        $validator = new Validator($data, [
            'reference' => 'required|min:3',
        ]);
        $errors = [];
        $result = null;
        if ($validator->fails() || !Security::verifyCsrf($data['_token'] ?? null)) {
            $errors[] = 'Lütfen geçerli bir referans numarası giriniz.';
        } else {
            $order = (new Order())->findByReference(trim($data['reference']));
            if ($order) {
                $result = $order;
            } else {
                $errors[] = 'Sipariş bulunamadı.';
            }
        }
        $content = $this->view->render('public.order_track', [
            'title' => 'Sipariş Takip',
            'csrf' => Security::csrfToken(),
            'result' => $result,
            'errors' => $errors,
        ]);
        return new Response($content, $errors ? 404 : 200);
    }
}

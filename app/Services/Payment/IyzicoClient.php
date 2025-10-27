<?php

namespace App\Services\Payment;

use Core\Config;
use Core\Logger;

class IyzicoClient
{
    private array $config;

    public function __construct()
    {
        $this->config = Config::get('payment.iyzico');
    }

    public function initiate(array $payload): array
    {
        Logger::info('Iyzico initiate called', $payload);
        // In absence of SDK, we simulate a redirect URL.
        return [
            'status' => 'redirect',
            'redirect_url' => '/payment/mock-success?provider=iyzico&order_id=' . $payload['order_id']
        ];
    }

    public function verifyCallback(array $data): array
    {
        Logger::info('Iyzico callback received', $data);
        $status = $data['status'] ?? 'failure';
        return [
            'status' => $status === 'success' ? 'completed' : 'failed',
            'transaction_id' => $data['transaction_id'] ?? uniqid('iyzico_'),
        ];
    }

    public function verifyWebhook(array $data, string $signature): bool
    {
        $secret = $this->config['secret_key'] ?? '';
        $computed = hash_hmac('sha256', json_encode($data), $secret);
        return hash_equals($computed, $signature);
    }
}

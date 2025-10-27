<?php

namespace App\Services\Payment;

use Core\Config;
use Core\Logger;

class PayTRClient
{
    private array $config;

    public function __construct()
    {
        $this->config = Config::get('payment.paytr');
    }

    public function initiate(array $payload): array
    {
        Logger::info('PayTR initiate called', $payload);
        return [
            'status' => 'redirect',
            'redirect_url' => '/payment/mock-success?provider=paytr&order_id=' . $payload['order_id']
        ];
    }

    public function verifyCallback(array $data): array
    {
        Logger::info('PayTR callback', $data);
        $status = $data['status'] ?? 'failure';
        return [
            'status' => $status === 'success' ? 'completed' : 'failed',
            'transaction_id' => $data['transaction_id'] ?? uniqid('paytr_'),
        ];
    }

    public function verifyWebhook(array $data, string $hash): bool
    {
        $merchantKey = $this->config['merchant_key'] ?? '';
        $merchantSalt = $this->config['merchant_salt'] ?? '';
        $generated = base64_encode(hash_hmac('sha256', json_encode($data) . $merchantSalt, $merchantKey, true));
        return hash_equals($generated, $hash);
    }
}

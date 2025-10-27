<?php

namespace App\Services\Provider;

use Core\Logger;

class MockProvider implements ProviderInterface
{
    public function createOrder(array $payload): array
    {
        $externalId = uniqid('mock_');
        Logger::info('Mock provider order created', ['external_id' => $externalId, 'payload' => $payload]);
        return ['status' => 'processing', 'external_id' => $externalId];
    }

    public function checkStatus(string $externalId): array
    {
        Logger::info('Mock provider status check', ['external_id' => $externalId]);
        return ['status' => 'completed', 'external_id' => $externalId];
    }

    public function cancel(string $externalId): array
    {
        Logger::info('Mock provider cancel', ['external_id' => $externalId]);
        return ['status' => 'canceled', 'external_id' => $externalId];
    }
}

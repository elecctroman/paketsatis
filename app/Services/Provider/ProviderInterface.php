<?php

namespace App\Services\Provider;

interface ProviderInterface
{
    public function createOrder(array $payload): array;
    public function checkStatus(string $externalId): array;
    public function cancel(string $externalId): array;
}

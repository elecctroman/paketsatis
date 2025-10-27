<?php

namespace App\Jobs;

use Core\Logger;

class SendWebhookJob
{
    public function handle(array $payload): void
    {
        Logger::info('Webhook dispatched', $payload);
    }
}

<?php
use App\Services\Provider\MockProvider;
use Core\DB;
use Core\Logger;

$provider = new MockProvider();
$orders = DB::query("SELECT id, external_ref FROM orders WHERE status = 'processing'")->fetchAll();
foreach ($orders as $order) {
    $result = $provider->checkStatus($order['external_ref'] ?? '');
    if (($result['status'] ?? '') === 'completed') {
        DB::query("UPDATE orders SET status = 'completed' WHERE id = :id", ['id' => $order['id']]);
        Logger::info('Order completed via poller', ['order_id' => $order['id']]);
    }
}

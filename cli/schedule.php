<?php
require __DIR__ . '/../public/bootstrap.php';

$jobs = [
    __DIR__ . '/jobs/order_status_poller.php',
    __DIR__ . '/jobs/daily_reports.php',
];

foreach ($jobs as $job) {
    if (is_file($job)) {
        require $job;
    }
}

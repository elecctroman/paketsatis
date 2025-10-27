<?php
use Core\DB;
use Core\Logger;

$today = date('Y-m-d');
$orders = DB::query("SELECT COUNT(*) FROM orders WHERE DATE(created_at) = :today", ['today' => $today])->fetchColumn();
$revenue = DB::query("SELECT IFNULL(SUM(total),0) FROM orders WHERE status = 'completed' AND DATE(created_at) = :today", ['today' => $today])->fetchColumn();
Logger::info('Daily report generated', ['orders' => $orders, 'revenue' => $revenue]);

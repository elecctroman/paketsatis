<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\Response;
use Core\DB;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalOrders = DB::query('SELECT COUNT(*) as total FROM orders')->fetchColumn();
        $monthlyRevenue = DB::query("SELECT IFNULL(SUM(total),0) FROM orders WHERE status = 'completed' AND MONTH(created_at) = MONTH(CURRENT_DATE())")->fetchColumn();
        $totalRevenue = DB::query("SELECT IFNULL(SUM(total),0) FROM orders WHERE status = 'completed'")->fetchColumn();
        $recentOrders = DB::query('SELECT id, status, total, created_at FROM orders ORDER BY created_at DESC LIMIT 5')->fetchAll();
        $content = $this->view->render('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'monthlyRevenue' => $monthlyRevenue,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
        ]);
        return new Response($content);
    }
}

<?php $this->extend('layouts.admin'); ?>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5>Toplam Sipariş</h5>
                <p class="display-6 text-primary"><?= (int) $totalOrders ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5>Bu Ayki Ciro</h5>
                <p class="display-6 text-success"><?= number_format((float) $monthlyRevenue, 2) ?> TL</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div a class="card-body">
                <h5>Toplam Ciro</h5>
                <p class="display-6 text-success"><?= number_format((float) $totalRevenue, 2) ?> TL</p>
            </div>
        </div>
    </div>
</div>
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white">
        Son 5 Sipariş
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Durum</th>
                    <th>Tutar</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                    <tr>
                        <td><?= (int) $order['id'] ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($order['status']) ?></span></td>
                        <td><?= number_format((float) $order['total'], 2) ?> TL</td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

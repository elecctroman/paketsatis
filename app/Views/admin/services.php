<?php $this->extend('layouts.admin'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4">Hizmetler</h1>
    <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#serviceForm">Yeni Hizmet</button>
</div>
<div class="collapse" id="serviceForm">
    <div class="card card-body mb-4">
        <form action="/admin/services" method="post" class="row g-3">
            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf) ?>">
            <div class="col-md-6">
                <label class="form-label">Ad</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kategori ID</label>
                <input type="number" name="category_id" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Min</label>
                <input type="number" name="min_qty" class="form-control" value="100">
            </div>
            <div class="col-md-6">
                <label class="form-label">Max</label>
                <input type="number" name="max_qty" class="form-control" value="1000">
            </div>
            <div class="col-md-6">
                <label class="form-label">Fiyat (1000 başına)</label>
                <input type="number" step="0.01" name="price_per_1000" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Garanti (gün)</label>
                <input type="number" name="guarantee_days" class="form-control" value="0">
            </div>
            <div class="col-12">
                <label class="form-label">Açıklama</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                    <label class="form-check-label" for="isActive">Aktif</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-success">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Fiyat</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= (int) $service['id'] ?></td>
                        <td><?= htmlspecialchars($service['name']) ?></td>
                        <td><?= number_format((float) $service['price_per_1000'], 2) ?> TL</td>
                        <td>
                            <?php if ((int) $service['is_active'] === 1): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Pasif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

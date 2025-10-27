<?php $this->extend('layouts.public'); ?>
<section>
    <h1 class="h3 mb-4" style="color:#1B3C74;"><?= htmlspecialchars($category['name']) ?> Paketleri</h1>
    <?php if (empty($services)): ?>
        <div class="alert alert-info">Bu kategori için aktif paket bulunamadı.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($services as $service): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <h2 class="h5" style="color:#1B3C74;"><?= htmlspecialchars($service['name']) ?></h2>
                            <p class="flex-grow-1"><?= htmlspecialchars(mb_strimwidth($service['description'] ?? '', 0, 120, '...')) ?></p>
                            <p class="fw-semibold mb-3">Başlangıç: <?= number_format((float) $service['price_per_1000'], 2) ?> TL / 1000</p>
                            <a class="btn btn-outline-primary" href="/services/<?= htmlspecialchars($service['slug']) ?>">Detayları Gör</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

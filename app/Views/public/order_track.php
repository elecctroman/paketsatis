<?php $this->extend('layouts.public'); ?>
<section>
    <h1 class="h3 mb-4" style="color:#1B3C74;">Sipariş Takip</h1>
    <form method="post" action="/order-track" class="row g-3 mb-4">
        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf) ?>">
        <div class="col-md-8">
            <label class="form-label">Referans Numarası / Sipariş ID</label>
            <input type="text" name="reference" class="form-control" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-100" style="background-color:#1B3C74;">Sorgula</button>
        </div>
    </form>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if ($result): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Sipariş Bilgileri</h2>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Sipariş ID</dt>
                    <dd class="col-sm-8">#<?= htmlspecialchars($result['id']) ?></dd>
                    <dt class="col-sm-4">Durum</dt>
                    <dd class="col-sm-8"><span class="badge bg-secondary text-uppercase"><?= htmlspecialchars($result['status']) ?></span></dd>
                    <dt class="col-sm-4">Toplam</dt>
                    <dd class="col-sm-8"><?= number_format((float) $result['total'], 2) ?> <?= htmlspecialchars($result['currency']) ?></dd>
                    <dt class="col-sm-4">Oluşturulma</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars(date('d.m.Y H:i', strtotime($result['created_at'] ?? 'now'))) ?></dd>
                </dl>
            </div>
        </div>
    <?php endif; ?>
</section>

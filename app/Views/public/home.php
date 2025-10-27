<?php $this->extend('layouts.public'); ?>
<?php $this->start('hero'); ?><?php $this->stop(); ?>
<section class="mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold" style="color:#1B3C74;">Sosyal Medya Büyümenizi Hızlandırın</h1>
            <p class="lead">Güvenilir sağlayıcılar, ölçeklenebilir altyapı ve 7/24 destek ile tüm SMM ihtiyaçlarınızı tek platformda karşılayın.</p>
            <a href="/checkout" class="btn btn-primary btn-lg" style="background-color:#5b4b8a;border:none;">Hemen Başla</a>
        </div>
        <div class="col-md-6 text-center">
            <img src="/assets/img/hero.png" class="img-fluid" alt="SMM" />
        </div>
    </div>
</section>
<section class="mb-5">
    <h2 class="h4 text-uppercase text-muted">Hızlı Sipariş</h2>
    <form action="/checkout" method="get" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Platform</label>
            <select class="form-select">
                <?php foreach ($categories as $category): ?>
                    <option><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Hizmet</label>
            <select class="form-select">
                <?php foreach ($services as $service): ?>
                    <option><?= htmlspecialchars($service['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-100" style="background-color:#1B3C74;">Siparişe Devam Et</button>
        </div>
    </form>
</section>
<section class="mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h3 class="h5">SSL Güvencesi</h3>
                    <p>256-bit şifreleme ile verileriniz korunur.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h3 class="h5">İade Garantisi</h3>
                    <p>Taahhüt edilen teslimat sağlanamazsa ücret iadesi.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h3 class="h5">7/24 Destek</h3>
                    <p>Uzman ekibimiz tüm sorularınıza yanıt verir.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <h2 class="h4">Popüler Paketler</h2>
    <div class="row">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h3 class="h5" style="color:#1B3C74;"><?= htmlspecialchars($service['name']) ?></h3>
                        <p><?= htmlspecialchars(mb_strimwidth($service['description'] ?? '', 0, 100, '...')) ?></p>
                        <p class="fw-bold"><?= number_format($service['price_per_1000'] ?? 0, 2) ?> TL / 1000</p>
                        <a href="/services/<?= htmlspecialchars($service['slug']) ?>" class="btn btn-outline-primary">Detay</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

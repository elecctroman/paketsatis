<?php $this->extend('layouts.public'); ?>
<section class="row">
    <div class="col-lg-8">
        <h1 class="h2 mb-3" style="color:#1B3C74;"><?= htmlspecialchars($service['name']) ?></h1>
        <p class="mb-4 text-muted">Teslimat: <?= (int) $service['guarantee_days'] ?> gün garanti</p>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <?= \Core\Security::sanitizeHtml($service['description'] ?? '') ?>
            </div>
        </div>
        <?php if (!empty($tiers)): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Fiyat Kademeleri</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Minimum</th>
                                    <th>Maksimum</th>
                                    <th>Fiyat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tiers as $tier): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($tier['min'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($tier['max'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($tier['price'] ?? '-') ?> TL</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Hızlı Sipariş</h2>
                <form action="/checkout/process" method="post" class="vstack gap-3">
                    <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf) ?>">
                    <input type="hidden" name="service_id" value="<?= (int) $service['id'] ?>">
                    <div>
                        <label class="form-label">Miktar</label>
                        <input type="number" min="<?= (int) $service['min_qty'] ?>" max="<?= (int) $service['max_qty'] ?>" name="quantity" class="form-control" required>
                        <small class="text-muted">Min <?= (int) $service['min_qty'] ?> - Max <?= (int) $service['max_qty'] ?></small>
                    </div>
                    <div>
                        <label class="form-label">E-posta</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Ödeme Yöntemi</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="iyzico">iyzico</option>
                            <option value="paytr">PayTR</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kupon</label>
                        <input type="text" name="coupon" class="form-control" placeholder="Opsiyonel">
                    </div>
                    <button class="btn btn-primary w-100" style="background-color:#1B3C74;">Sepete Ekle</button>
                </form>
            </div>
        </div>
    </div>
</section>

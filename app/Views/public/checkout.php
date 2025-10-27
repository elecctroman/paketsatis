<?php $this->extend('layouts.public'); ?>
<h1 class="h3 mb-4" style="color:#1B3C74;">Sepet ve Ödeme</h1>
<form action="/checkout/process" method="post" class="card shadow-sm p-4" id="checkout-form">
    <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf) ?>">
    <div class="mb-3">
        <label class="form-label">Hizmet</label>
        <select name="service_id" class="form-select">
            <?php foreach ($services as $service): ?>
                <option value="<?= (int) $service['id'] ?>"><?= htmlspecialchars($service['name']) ?> - <?= number_format($service['price_per_1000'] ?? 0, 2) ?> TL</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Adet</label>
            <input type="number" name="quantity" class="form-control" min="1" value="100">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Kupon Kodu</label>
        <input type="text" name="coupon" class="form-control" placeholder="Opsiyonel">
    </div>
    <div class="mb-3">
        <label class="form-label">Ödeme Yöntemi</label>
        <select name="payment_method" class="form-select">
            <option value="iyzico">iyzico</option>
            <option value="paytr">PayTR</option>
        </select>
    </div>
    <button class="btn btn-primary" style="background-color:#1B3C74;">Ödemeye Geç</button>
</form>
<div id="checkout-result" class="alert mt-4 d-none"></div>
<script>
    document.getElementById('checkout-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        }).then(res => res.json()).then(data => {
            const result = document.getElementById('checkout-result');
            if (data.redirect) {
                result.classList.remove('d-none', 'alert-danger');
                result.classList.add('alert', 'alert-success');
                result.textContent = 'Ödeme sayfasına yönlendiriliyorsunuz...';
                setTimeout(() => window.location.href = data.redirect, 1200);
            } else {
                result.classList.remove('d-none', 'alert-success');
                result.classList.add('alert', 'alert-danger');
                result.textContent = 'İşlem sırasında hata oluştu.';
            }
        }).catch(() => {
            const result = document.getElementById('checkout-result');
            result.classList.remove('d-none', 'alert-success');
            result.classList.add('alert', 'alert-danger');
            result.textContent = 'Sunucuya erişilemedi.';
        });
    });
</script>

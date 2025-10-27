<?php $this->extend('layouts.public'); ?>
<h1 class="h3 mb-4" style="color:#1B3C74;">Yönetim Girişi</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form action="/login" method="post" class="card shadow-sm p-4">
    <input type="hidden" name="_token" value="<?= htmlspecialchars($csrf) ?>">
    <div class="mb-3">
        <label class="form-label">E-posta</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Şifre</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary" style="background-color:#1B3C74;">Giriş Yap</button>
</form>

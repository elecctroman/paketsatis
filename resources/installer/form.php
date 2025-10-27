<?php ob_start(); ?>
<form method="post" class="needs-validation" novalidate>
    <input type="hidden" name="step" value="2">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-label">Veritabanı Host</label>
        <input type="text" name="db_host" class="form-control" required value="localhost">
    </div>
    <div class="mb-3">
        <label class="form-label">Veritabanı Adı</label>
        <input type="text" name="db_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Veritabanı Kullanıcı</label>
        <input type="text" name="db_user" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Veritabanı Şifre</label>
        <input type="password" name="db_pass" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Site Adı</label>
        <input type="text" name="app_name" class="form-control" required value="PaketSatis">
    </div>
    <div class="mb-3">
        <label class="form-label">Admin E-posta</label>
        <input type="email" name="admin_email" class="form-control" required value="admin@example.com">
    </div>
    <div class="mb-3">
        <label class="form-label">Admin Şifre</label>
        <input type="password" name="admin_pass" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Kurulumu Başlat</button>
</form>
<?php $content = ob_get_clean(); include __DIR__ . '/layout.php'; ?>

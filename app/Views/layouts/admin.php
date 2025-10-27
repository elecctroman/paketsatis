<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Yönetim - PaketSatis') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">
</head>
<body>
<nav class="navbar navbar-dark" style="background-color:#1B3C74;">
    <div class="container-fluid">
        <span class="navbar-brand">Yönetim Paneli</span>
        <a class="btn btn-outline-light" href="/logout">Çıkış</a>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 bg-light vh-100 border-end">
            <ul class="nav flex-column py-3">
                <li class="nav-item"><a class="nav-link" href="/admin">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/services">Hizmetler</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/orders">Siparişler</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/coupons">Kuponlar</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/settings">Ayarlar</a></li>
            </ul>
        </aside>
        <main class="col-md-10 py-4">
            <?= $content_for_layout ?? '' ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

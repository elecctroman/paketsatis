<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'PaketSatis') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
</head>
<body class="bg-light" style="font-family: 'Inter', sans-serif;">
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#1B3C74;">
    <div class="container">
        <a class="navbar-brand" href="/">PaketSatis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="/pages/hakkimizda">Hakkımızda</a></li>
                <li class="nav-item"><a class="nav-link" href="/order-track">Sipariş Takip</a></li>
                <li class="nav-item"><a class="nav-link" href="/login">Giriş</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="py-5">
    <div class="container">
        <?= $content_for_layout ?? '' ?>
    </div>
</main>
<footer class="py-4" style="background-color:#0f2142;color:#fff;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>PaketSatis</h5>
                <p>Kurumsal SMM çözümlerinde güvenilir ortağınız.</p>
            </div>
            <div class="col-md-3">
                <h6>Bağlantılar</h6>
                <ul class="list-unstyled">
                    <li><a class="text-white" href="/pages/kvkk">KVKK</a></li>
                    <li><a class="text-white" href="/pages/iade-politikasi">İade Politikası</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Destek</h6>
                <p>7/24 Canlı Destek</p>
            </div>
        </div>
        <p class="text-center mt-4">© <?= date('Y') ?> PaketSatis</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('assets/js/app.js') ?>"></script>
</body>
</html>

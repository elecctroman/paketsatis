<?php $this->extend('layouts.public'); ?>
<article class="blog-post">
    <h1 class="h2 mb-3" style="color:#1B3C74;"><?= htmlspecialchars($post['title']) ?></h1>
    <p class="text-muted">Yayın Tarihi: <?= htmlspecialchars(date('d.m.Y', strtotime($post['published_at'] ?? 'now'))) ?></p>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= $body ?>
        </div>
    </div>
    <a class="btn btn-link mt-4" href="/blog">← Tüm yazılara dön</a>
</article>

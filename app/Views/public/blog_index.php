<?php $this->extend('layouts.public'); ?>
<section>
    <h1 class="h3 mb-4" style="color:#1B3C74;">Blog</h1>
    <?php if (empty($posts)): ?>
        <div class="alert alert-info">Henüz blog yazısı bulunmuyor.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-secondary align-self-start mb-2">Blog</span>
                            <h2 class="h5" style="color:#1B3C74;"><?= htmlspecialchars($post['title']) ?></h2>
                            <p class="text-muted flex-grow-1"><?= htmlspecialchars(mb_strimwidth(strip_tags($post['body_html'] ?? ''), 0, 120, '...')) ?></p>
                            <a class="stretched-link" href="/blog/<?= htmlspecialchars($post['slug']) ?>">Devamını oku</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

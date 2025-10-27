<?php $this->extend('layouts.public'); ?>
<section class="page-content">
    <h1 class="h2 mb-3" style="color:#1B3C74;"><?= htmlspecialchars($page['title']) ?></h1>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?= $body ?>
        </div>
    </div>
</section>

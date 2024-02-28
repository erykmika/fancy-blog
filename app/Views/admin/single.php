<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php if (!empty($article) && is_array($article)): ?>
    <div class="container my-5">
        <div class="container-sm">
            <?php foreach ($article['categories'] as $category): ?>
                <?= $category ?>
            <?php endforeach; ?>
        </div>
        <div>
            <?= esc($article["title"]) ?>
        </div>
        <div>
            <?= esc($article["content"]) ?>
        </div>
        <div>
            <?= esc($article["date"]) ?>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
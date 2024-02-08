<?= $this->extend('articles/layout') ?>
<?= $this->section('content') ?>
<?php if ( ! empty($article) && is_array($article)): ?>
        <div class="container my-5">
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

<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php $colors = ['text-primary', 'text-danger', 'text-warning', 'text-secondary', 'text-success']; ?>
<?php if (!empty($article) && is_array($article)) : ?>
    <?php shuffle($colors); ?>
    <div class="container my-5">
        <div class="container-sm">
            <?php foreach ($article['categories'] as $index => $category) : ?>
                <span class="<?= $colors[$index] ?>"><?= $category ?></span>
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
<?= $this->extend('articles/layout') ?>
<?= $this->section('content') ?>
<?php if (!empty($articles) && is_array($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <div class="container my-5">
            <div>
                <a href="/articles/<?= esc($article["id"]) ?>"><?= esc($article["title"]) ?></a>
            </div>
            <div>
                <?= esc($article["content"]) ?>
            </div>
            <div>
                <?= esc($article["date"]) ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($numOfPages) && is_int($numOfPages)): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for ($i = 0; $i < $numOfPages; $i++): ?>
                <?php if ($i + 1 != $curPageNum): ?>
                    <li class="page-item">
                        <a class="page-link" href="/<?= $i + 1 ?>">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item active">
                        <a class="page-link" href="/<?= $i + 1 ?>">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
<?= $this->endSection() ?>

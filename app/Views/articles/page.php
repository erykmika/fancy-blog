<?= $this->extend('articles/layout') ?>
<?= $this->section('content') ?>
<?php if (!empty($articles) && is_array($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <div class="container my-5">
            <div>
                <a href="/article/<?= esc($article["id"]) ?>"><?= esc($article["title"]) ?></a>
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

<?php if (isset($num_of_pages) && is_int($num_of_pages)): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for ($i = 0; $i < $num_of_pages; $i++): ?>
                <?php if ($i + 1 != $cur_page_num): ?>
                    <li class="page-item">
                        <a class="page-link" href="/page/<?= $i + 1 ?>">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item active">
                        <a class="page-link" href="/page/<?= $i + 1 ?>">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
<?= $this->endSection() ?>

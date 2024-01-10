<?php if (!empty($articles) && is_array($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <div class="article">
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
    <ul class="navbar">
            <?php for ($i = 0; $i < $numOfPages; $i++): ?>
                <?php if ($i + 1 != $curPageNum): ?>
                    <li>
                        <a href="/<?= $i + 1 ?>" class="not-current">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/<?= $i + 1 ?>">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
    </ul>
<?php endif; ?>
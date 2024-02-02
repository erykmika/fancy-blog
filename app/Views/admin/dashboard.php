<div class="logout">
    <a href="/admin/logout">Logout</a>
</div>

<div class="add">
    <a href="/admin/add">Add an article</a>
</div>

<?php if (!empty($articles) && is_array($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <div>
                <a href="/admin/<?= esc($article["id"]) ?>"><?= esc($article["title"]) ?></a>
            </div>
            <div>
                <?= esc($article["content"]) ?>
            </div>
            <div>
                <?= esc($article["date"]) ?>
            </div>
            <div class="delete">
                <form method="post" action="/admin/delete/<?= esc($article["id"]) ?>"
                onsubmit="return confirm('Are you sure?');">
                <input type="submit" value="Delete">
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($numOfPages) && is_int($numOfPages)): ?>
    <ul class="navbar">
            <?php for ($i = 0; $i < $numOfPages; $i++): ?>
                <?php if ($i + 1 != $curPageNum): ?>
                    <li>
                        <a href="/admin/<?= $i + 1 ?>" class="not-current">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/admin/<?= $i + 1 ?>">
                            <?= esc($i + 1) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
    </ul>
<?php endif; ?>
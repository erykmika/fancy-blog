<?php if ( ! empty($articles) && is_array($articles) ) : ?>
    <?php foreach ($articles as $article) : ?>
        <div class="article">
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
    <?php endforeach; ?>
<?php endif; ?>

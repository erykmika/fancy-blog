<?php if ( ! empty($article) && is_array($article)): ?>
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
<?php endif; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <form method="post" action="">
        <div>
            <?php if (isset($article['title'])) : ?>
                <textarea placeholder="<?= $article['title'] ?>" name="title" required><?= $article['title'] ?></textarea>
            <?php else : ?>
                <textarea placeholder="New title" name="title" required></textarea>
            <?php endif; ?>
        </div>
        <div>
            <?php if (isset($article['content'])) : ?>
                <textarea placeholder="<?= $article['content'] ?>" name="content" required><?= $article['content'] ?></textarea>
            <?php else : ?>
                <textarea placeholder="New content" name="content" required></textarea>
            <?php endif; ?>
        </div>
        <fieldset>
            <legend>Select categories: </legend>
            <div>
                <?php foreach ($categories as $category => $state) : ?>
                    <div>
                        <input type="checkbox" id="<?= $category ?>" name="<?= $category ?>" <?= (($state === "on") ? "checked" : "") ?> />
                        <label for="<?= $category ?>">
                            <?= $category ?>
                        </label>
                    </div>
                <?php endforeach; ?>
        </fieldset>
        <div>
            <input type="submit" value="Edit the article">
        </div>
    </form>
</div>
<?= $this->endSection() ?>
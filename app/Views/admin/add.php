<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <form method="post" action="">
        <div>
            <input type="text" placeholder="Title of article" name="title" required>
        </div>
        <div>
            <textarea placeholder="Content" name="content" required></textarea>
        </div>
        <div>
            <input type="submit" value="Add the article">
        </div>
    </form>
</div>
<?= $this->endSection() ?>

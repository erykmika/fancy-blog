<?php

require 'vendor/autoload.php';
require 'includes/header.php';

$db_con = Database::getDatabase()->getCon();
$stmt = $db_con->query("SELECT title, content, date FROM Article;");
$result = $stmt->fetchAll(PDO::FETCH_CLASS, "Article");

?>

<?php foreach($result as $article): ?>
    <div class="article">
        <div>
            <?= $article->getTitle() ?>
        </div>
        <div>
            <?= $article->getContent() ?>
        </div>
        <div>
            <?= $article->getDate() ?>
        </div>
    </div>
<?php endforeach; ?>

<?php require 'includes/footer.php' ?>
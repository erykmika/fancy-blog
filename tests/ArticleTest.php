<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

final class ArticleTest extends TestCase
{
    public function testIdCanBeSetAndRetrieved(): void
    {
        $id = 2;

        $testArticle = new Article();
        $testArticle->setID($id);

        $this->assertSame($id, $testArticle->getID());
    }

    public function testTitleCanBeSetAndRetrieved(): void
    {
        $title = "Hello, world!";

        $testArticle = new Article();
        $testArticle->setTitle($title);

        $this->assertSame($title, $testArticle->getTitle());
    }

    public function testContentCanBeSetAndRetrieved(): void
    {
        $content = "abc123";

        $testArticle = new Article();
        $testArticle->setContent($content);

        $this->assertSame($content, $testArticle->getContent());
    }
}
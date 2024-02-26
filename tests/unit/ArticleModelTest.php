<?php

declare(strict_types=1);

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

use App\Models\ArticleModel;

class ArticleModelTest extends CIUnitTestCase
{
    // Use the database trait. An SQLite database is used for testing.
    use DatabaseTestTrait;

    /**
     * Database seed
     */
    protected $seed = 'ArticleTestSeeder';

    /**
     * Seed once
     */
    protected $seedOnce = false;

    /**
     * Article model tested
     */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ArticleModel();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function testArticlesCanBePaginated(): void
    {
        $paginated = $this->model->getArticlesPaginated(page: 2, page_size: 2);
        $this->assertEquals(1, count($paginated));
    }

    public function testArticleCanBeRetrievedById(): void
    {
        $article = $this->model->getArticle(3);
        $this->assertEquals('Reflections', $article['title']);
    }

    public function testNumberOfPagesIsCorrect(): void
    {
        $numberOfPages = $this->model->getNumOfPages(page_size: 2);
        $this->assertEquals(2, $numberOfPages);
    }

    public function testArticleCanBeCreated(): void
    {
        $title = 'TestTitle';
        $content = 'TestContent';
        $this->model->createArticle($title, $content, []);
        $criteria = [
            'title' => $title,
            'content' => $content
        ];
        $this->seeInDatabase('Article', $criteria);
    }

    public function testArticleCanBeUpdated(): void
    {
        $new_title = 'NewTitle';
        $new_content = 'NewContent';
        $this->model->updateArticle(1, $new_title, $new_content);
        $this->seeInDatabase('Article', [
            'id' => 1,
            'title' => $new_title,
            'content' => $new_content
        ]);
    }

    public function testArticleCanBeDeleted(): void
    {
        $id = 1;
        $this->model->deleteArticle($id);
        $criteria = [
            'title' => 'New Beginnings',
            'content' => 'Exploring new opportunities',
        ];
        $this->dontSeeInDatabase('Article', $criteria);
    }
}

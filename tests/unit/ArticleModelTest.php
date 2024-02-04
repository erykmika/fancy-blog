<?php

use App\Models\ArticleModel;
use Codeigniter\Test\CIUnitTestCase;
use Codeigniter\Test\DatabaseTestTrait;


class ArticleModelTest extends CIUnitTestCase
{
    // Use the database trait. A SQLite database is used for testing.
    use DatabaseTestTrait;

    // Seeding the database
    protected $seed = 'ArticleSeeder';
    protected $seedOnce = false;

    // Tested article model
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

    public function testArticlesCanBePaginated()
    {
        $paginated = $this->model->getArticlesPaginated(page: 2, page_size: 2);
        $this->assertEquals(1, count($paginated));
    }

    public function testArticleCanBeRetrievedById()
    {
        $article = $this->model->getArticle(3);
        $this->assertEquals('Reflections', $article['title']);
    }

    public function testNumberOfPagesIsCorrect()
    {
        $numberOfPages = $this->model->getNumOfPages(page_size: 2);
        $this->assertEquals(2, $numberOfPages);
    }

    public function testArticleCanBeCreated()
    {
        $title = 'TestTitle';
        $content = 'TestContent';
        $this->model->createArticle($title, $content);
        $criteria = [
            'title' => $title,
            'content' => $content
        ];
        $this->seeInDatabase('Article', $criteria);
    }

    public function testArticleCanBeDeleted()
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

<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\ControllerTestTrait;

use App\Controllers\Articles;

class ArticlesTest extends CIUnitTestCase
{
    // Use the database trait. An SQLite database is used for testing.
    use DatabaseTestTrait;
    // Use the controller trait as the controller is tested.
    use ControllerTestTrait;

    /**
     * Database seed - prepare the 'Article' table in the test database
     */
    protected $seed = 'ArticleTestSeeder';

    /**
     * Seed once
     */
    protected $seedOnce = false;

    /**
     * Controller tested
     */
    protected $controller;


    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Articles();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->controller);
    }

    public function testArticleViewResponseIsOk()
    {
        // Id of the article that is viewed
        $testedId = 1;
        $result = $this->withUri("http://localhost:8080/article/" . $testedId)
            ->controller(Articles::class)
            ->execute('viewArticle', ['article_id' => $testedId]);
        $this->assertTrue($result->isOK());
    }

    public function testPaginationViewResponseIsOk()
    {
        // Number of page that is viewed
        $page_num = 1;
        $result = $this->withUri("http://localhost:8080/page/" . $page_num)
            ->controller(Articles::class)
            ->execute('viewPage', ['page_num' => $page_num]);
        $this->assertTrue($result->isOK());
    }
}

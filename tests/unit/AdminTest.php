<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\ControllerTestTrait;

use App\Controllers\Admin;

class AdminTest extends CIUnitTestCase
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
        $this->controller = new Admin();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->controller);
    }

    public function testAdminMustBeAuthorizedToDisplayDashboard()
    {
        $pageNum = 1;
        $result = $this->withUri("http://localhost:8080/admin/page/" . $pageNum)
            ->controller(Admin::class)
            ->execute('displayDashboardPage', ['pageNum' => $pageNum]);
        $this->assertTrue(!$result->isOK());
    }

    public function testAdminMustBeAuthorizedToDisplayArticle()
    {
        $articleId = 1;
        $result = $this->withUri("http://localhost:8080/admin/article/" . $articleId)
            ->controller(Admin::class)
            ->execute('displayArticlePage', ['articleId' => $articleId]);
        $this->assertTrue(!$result->isOK());
    }

    public function testAdminMustBeAuthorizedToDisplayAddPage()
    {
        $result = $this->withUri("http://localhost:8080/admin/add/")
            ->controller(Admin::class)
            ->execute('displayAddPage');
        $this->assertTrue(!$result->isOK());
    }

    public function testAdminMustBeAuthorizedToDisplayEditPage()
    {
        $articleId = 1;
        $result = $this->withUri("http://localhost:8080/admin/edit/" . $articleId)
            ->controller(Admin::class)
            ->execute('displayEditPage', ['articleId' => $articleId]);
        $this->assertTrue(!$result->isOK());
    }
}

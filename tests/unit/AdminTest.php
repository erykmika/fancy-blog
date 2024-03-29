<?php

declare(strict_types=1);

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
    protected $seed = 'DatabaseTestSeeder';


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

    public function testAdminMustBeAuthorizedToDisplayDashboard(): void
    {
        $page_num = 1;
        $result = $this->withUri("http://localhost:8080/admin/page/" . $page_num)
            ->controller(Admin::class)
            ->execute('displayDashboardPage', $page_num);
        $this->assertTrue(!$result->isOK());
    }

    public function testAdminMustBeAuthorizedToDisplayArticle(): void
    {
        $article_id = 1;
        $result = $this->withUri("http://localhost:8080/admin/article/" . $article_id)
            ->controller(Admin::class)
            ->execute('displayArticlePage', $article_id);
        $this->assertTrue(!$result->isOK());
    }

    public function testAdminMustBeAuthorizedToDisplayAddPage(): void
    {
        $result = $this->withUri("http://localhost:8080/admin/add/")
            ->controller(Admin::class)
            ->execute('displayAddPage');
        $this->assertTrue(!$result->isOK());
    }

    public function testAdminMustBeAuthorizedToDisplayEditPage(): void
    {
        $article_id = 1;
        $result = $this->withUri("http://localhost:8080/admin/edit/" . $article_id)
            ->controller(Admin::class)
            ->execute('displayEditPage', $article_id);
        $this->assertTrue(!$result->isOK());
    }
}

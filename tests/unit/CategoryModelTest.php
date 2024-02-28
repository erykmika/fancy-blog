<?php

declare(strict_types=1);

use App\Models\CategoryModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class CategoryModelTest extends CIUnitTestCase
{
    // Use the database trait. An SQLite database is used for testing.
    use DatabaseTestTrait;

    /**
     * Database seed
     */
    protected $seed = 'DatabaseTestSeeder';

    /**
     * Seed once
     */
    protected $seedOnce = false;

    /**
     * Category model tested
     */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CategoryModel();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function testNumberOfCategoriesIsOk(): void
    {
        $category_data = $this->model->getCategories();
        $this->assertSame(3, count($category_data));
    }

    public function testRetrievedCategoryNameIsCorrect(): void
    {
        $category_data = $this->model->getCategories();
        $this->assertSame('Sport', $category_data[2]);
    }
}

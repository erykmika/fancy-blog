<?php

declare(strict_types=1);

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArticlesCategoryMigration extends Migration
{
    protected $DBGroup = 'tests';

    public function up(): void
    {
        // Create the Article table
        $this->db->query("CREATE TABLE IF NOT EXISTS Article ( 
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(50) NOT NULL,
            content TEXT NOT NULL,
            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
            );");

        // Create the Category table
        $this->db->query("CREATE TABLE IF NOT EXISTS Category (
            id INT PRIMARY KEY,
            name VARCHAR(20) UNIQUE
            );");

        // Create the ArticleCategory table
        $this->db->query("CREATE TABLE IF NOT EXISTS ArticleCategory (
            articleId INT,
            categoryId INT,
            PRIMARY KEY (articleId, categoryId),
            FOREIGN KEY (articleId) REFERENCES Article(id) ON DELETE CASCADE,
            FOREIGN KEY (categoryId) REFERENCES Category(id) ON DELETE CASCADE
            );");
    }

    public function down(): void
    {
        $this->db->query("DROP TABLE ArticleCategory;");
        $this->db->query("DROP TABLE Category;");
        $this->db->query("DROP TABLE Article;");
    }
}

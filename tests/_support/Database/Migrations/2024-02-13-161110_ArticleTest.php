<?php

declare(strict_types=1);

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArticleTest extends Migration
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
    }

    public function down(): void
    {
        // Remove all records from the database
        $this->db->query("DELETE FROM Article;");
    }
}

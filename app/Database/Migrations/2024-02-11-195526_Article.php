<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Article extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'null' => false,
                'auto_increment' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('Article');
    }

    public function down(): void
    {
        $this->forge->dropTable('Article');
    }
}

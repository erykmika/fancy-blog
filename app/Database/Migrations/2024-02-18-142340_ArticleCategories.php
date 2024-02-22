<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArticleCategories extends Migration
{
    public function up()
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
        $this->forge->createTable('Article', true);

        $this->forge->reset();

        $this->forge->addField(['id INT NOT NULL AUTO_INCREMENT,
                                name VARCHAR(20) NOT NULL UNIQUE'
        ]);

        $this->forge->addKey(['id'], true);
        $this->forge->createTable('Category', true);

        $this->forge->reset();

        // A junction table - a many-to-many relationship: articles <-> categories
        $this->forge->addField(['articleId INT NOT NULL,
                                categoryId INT NOT NULL'
        ]);

        $this->forge->createTable('ArticleCategory', true);

        // Composite primary key
        $this->db->query(<<<SQL
        ALTER TABLE ArticleCategory
        ADD PRIMARY KEY (articleId, categoryId);
        SQL);

        // Foreign keys

        $this->db->query(<<<SQL
        ALTER TABLE ArticleCategory
        ADD FOREIGN KEY (articleId)
        REFERENCES Article(id)
        ON DELETE CASCADE;
        SQL);

        $this->db->query(<<<SQL
        ALTER TABLE ArticleCategory
        ADD FOREIGN KEY (categoryId)
        REFERENCES Category(id)
        ON DELETE CASCADE;
        SQL);
    }

    public function down()
    {
        $this->forge->dropTable('Article', true, true);
        $this->forge->dropTable('Category', true, true);
        $this->forge->dropTable('ArticleCategory', true, true);
    }
}

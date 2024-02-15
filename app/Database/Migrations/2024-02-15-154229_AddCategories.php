<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategories extends Migration
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
                                name VARCHAR(10) NOT NULL UNIQUE']);

        $this->forge->addKey(['id'], true);
        $this->forge->createTable('Category', true);

        $this->forge->reset();

        // A junction table - a many-to-many relationship: articles <-> categories
        $this->forge->addField(['articleId INT NOT NULL,
                                categoryId INT NOT NULL']);

        // Composite primary key
        $this->forge->createTable('ArticleCategory', true); 
        $this->db->query('ALTER TABLE ArticleCategory ADD PRIMARY KEY (articleId, categoryId);');

        // Foreign keys
        $this->db->query('ALTER TABLE ArticleCategory ADD FOREIGN KEY (articleId) REFERENCES Article(id);');
        $this->db->query('ALTER TABLE ArticleCategory ADD FOREIGN KEY (categoryId) REFERENCES Category(id);');
    }

    public function down()
    {
        $this->forge->dropTable('Article');
        $this->forge->dropTable('Category');
        $this->forge->dropTable('ArticleCategory');
    }
}

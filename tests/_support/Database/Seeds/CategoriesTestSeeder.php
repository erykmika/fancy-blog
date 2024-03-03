<?php

declare(strict_types=1);

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesTestSeeder extends Seeder
{
    public function run(): void
    {
        // Insert sample categories into the 'Category' table
        $categories = [
            1 => 'Technology',
            2 => 'Sport',
            3 => 'Animals',
        ];

        foreach ($categories as $id => $name) {
            $this->db->query("INSERT INTO Category (id, name) VALUES ({$id}, '{$name}');");
        }

        /* 
            Create a many-to-many relationship between 'Article' and 'Category'
        */

        // Get 'Article' ids
        $result = $this->db->query("SELECT id FROM Article;")->getResult('array');
        $article_ids = [];
        foreach ($result as $id_row) {
            $article_ids[] = $id_row['id'];
        }

        // For each article (article id), add a random number (<1, 3>) of categories to it
        foreach ($article_ids as $article_id) {
            $number_of_categories = rand(2, 3);
            $picked_category_ids = array_rand($categories, $number_of_categories);
            foreach ($picked_category_ids as $category_id) {
                $sql = <<<SQL
                    INSERT INTO ArticleCategory (articleId, categoryId) 
                    VALUES ({$article_id}, {$category_id}); 
                SQL;
                $this->db->query($sql);
            }
        }
    }
}

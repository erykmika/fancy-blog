<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): mixed
    {
        // Insert sample categories into the 'Category' table
        $categories = [
            1 => 'Technology',
            2 => 'Sport',
            3 => 'Animals',
            4 => 'Programming',
            5 => 'Games',
        ];

        foreach ($categories as $id => $name) {
            $this->db->query("INSERT INTO Category (id, name) VALUES ({$id}, '{$name}');");
        }

        /* 
            Create random many-to-many relationships between 'Article' and 'Category'
        */

        // Get 'Article' ids
        $result = $this->db->query("SELECT id FROM Article;")->getResult('array');
        $article_ids = [];
        foreach ($result as $id_row) {
            $article_ids[] = $id_row['id'];
        }

        // For each article (article id), add a random number (<2, 4>) of categories to it
        foreach ($article_ids as $article_id) {
            $number_of_categories = rand(2, 4);
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

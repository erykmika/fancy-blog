<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Remove all records from the database first
        $this->db->query("DELETE FROM Article;");

        // Data used for seeding
        $article_data = [];

        $article_data[1] = [
            'title' => 'New Beginnings',
            'content' => 'Exploring new opportunities',
            'date' => '2023-02-06 09:45:30'
        ];

        $article_data[2] = [
            'title' => 'The Adventure Continues',
            'content' => 'Embarking on a journey of a lifetime',
            'date' => '2023-02-07 18:12:45'
        ];

        $article_data[3] = [
            'title' => 'Reflections',
            'content' => 'Looking back on the past and planning for the future',
            'date' => '2023-02-08 12:01:10'
        ];

        // Add articles with data contained in the 'article_data' array
        foreach ($article_data as $index => $entry) {
            $query = <<<SQL
            INSERT INTO Article (id, title, content, date) 
            VALUES ($index, '{$entry['title']}', '{$entry['content']}', '{$entry['date']}');
            SQL;
            $this->db->query($query);
        }
    }
}
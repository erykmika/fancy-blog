<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        /**
         *  Data used for seeding the development database
         */
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

        $article_data[4] = [
            'title' => 'Discoveries Unveiled',
            'content' => 'Uncovering hidden gems in the journey of life',
            'date' => '2023-02-09 15:30:20'
        ];

        $article_data[5] = [
            'title' => 'Challenges and Triumphs',
            'content' => 'Overcoming obstacles and celebrating victories',
            'date' => '2023-02-10 08:55:05'
        ];

        $article_data[6] = [
            'title' => 'A Glimpse into the Future',
            'content' => 'Anticipating what lies ahead in the path of destiny',
            'date' => '2023-02-11 20:45:30'
        ];

        $article_data[7] = [
            'title' => 'Serendipitous Moments',
            'content' => 'Embracing unexpected joys and surprises',
            'date' => '2023-02-12 14:20:15'
        ];

        $article_data[8] = [
            'title' => 'Harmony in Chaos',
            'content' => 'Finding balance amidst the chaos of life',
            'date' => '2023-02-13 09:10:55'
        ];

        $article_data[9] = [
            'title' => 'Journey of Self-Discovery',
            'content' => "Unraveling the layers of one\'s own identity",
            'date' => '2023-02-14 17:30:40'
        ];

        $article_data[10] = [
            'title' => 'Embracing Change',
            'content' => 'Adapting to the ever-evolving tapestry of life',
            'date' => '2023-02-15 12:45:00'
        ];

        // Add articles with data contained in the 'article_data' array
        foreach ($article_data as $index => $entry) {
            /**
             * SQL insert query
             */
            $query = <<<SQL
            INSERT INTO Article (id, title, content, date) 
            VALUES ($index, '{$entry['title']}', '{$entry['content']}', '{$entry['date']}');
            SQL;
            $this->db->query($query);
        }
    }
}

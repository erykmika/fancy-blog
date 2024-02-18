<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Nested database seeder
 */
class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call('ArticleSeeder');
        $this->call('CategoriesSeeder');
    }
}

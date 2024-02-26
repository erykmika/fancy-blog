<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Nested database seeder
 */
class DatabaseSeeder extends Seeder
{

    public function run(): mixed
    {
        $this->call('ArticleSeeder');
        $this->call('CategoriesSeeder');
    }
}

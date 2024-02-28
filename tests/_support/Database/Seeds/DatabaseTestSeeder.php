<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Nested testing database seeder
 */
class DatabaseTestSeeder extends Seeder
{

    public function run(): void
    {
        $this->call('Tests\\Support\\Database\\Seeds\\ArticlesTestSeeder');
        $this->call('Tests\\Support\\Database\\Seeds\\CategoriesTestSeeder');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Blog\Database\Seeders\BlogSeeder;
use Modules\Documentation\Database\Seeders\DocumentationSeeder;
use Modules\Option\Database\Seeders\OptionSeeder;
use Modules\Page\Database\Seeders\PageSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            OptionSeeder::class,
            DocumentationSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
        ]);
    }
}

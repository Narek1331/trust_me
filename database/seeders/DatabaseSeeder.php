<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\{
    RoleSeeder,
    UserSeeder,
    CheckSeeder,
    ReviewTypeSeeder,
    RatingSeeder,
    AdCategorySeeder,
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CheckSeeder::class,
            ReviewTypeSeeder::class,
            RatingSeeder::class,
            AdCategorySeeder::class
        ]);
    }
}

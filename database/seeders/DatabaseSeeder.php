<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([PermissionSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([RestaurantSeeder::class]);
        $this->call([ReviewSeeder::class]);
        $this->call([FavoriteReviewSeeder::class]);
        $this->call([FavoriteRestaurantSeeder::class]);
    }
}

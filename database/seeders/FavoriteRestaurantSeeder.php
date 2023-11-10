<?php

namespace Database\Seeders;

use App\Models\FavoriteRestaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FavoriteRestaurant::create([
            'user_id' => 1,
            'restaurant_id' => 1,
            'created_at' => '2023-11-21'
        ]);

        FavoriteRestaurant::create([
            'user_id' => 1,
            'restaurant_id' => 2,
            'created_at' => '2023-11-21'
        ]);

        FavoriteRestaurant::create([
            'user_id' => 2,
            'restaurant_id' => 2,
            'created_at' => '2023-11-21'
        ]);
        
        FavoriteRestaurant::create([
            'user_id' => 3,
            'restaurant_id' => 3,
            'created_at' => '2023-11-21'
        ]);
        
        FavoriteRestaurant::create([
            'user_id' => 3,
            'restaurant_id' => 2,
            'created_at' => '2023-11-21'
        ]);
        
    }
}

<?php

namespace Database\Seeders;

use App\Models\FavoriteReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FavoriteReview::create([
            'user_id' => 1,
            'review_id' => 2,
            'created_at' => '2023-11-22'
        ]);
        FavoriteReview::create([
            'user_id' => 1,
            'review_id' => 3,
            'created_at' => '2023-11-22'
        ]);

    }
}

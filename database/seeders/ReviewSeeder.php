<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::create([
            'title' => 'El mejor Restaurante de este lado del estado he probado.',
            'description' => 'Si tenian marucahn :D',
            'user_id' => 1,
            'restaurant_id' => 1,
            'created_at' => '2023-11-20',
            'updated_at' => '2023-11-20'
        ]);
        Review::create([
            'title' => 'El mejor Restaurante de takis que he probado.',
            'description' => 'Tenian todas las bolsas de takis :D.',
            'user_id' => 3,
            'restaurant_id' => 2,
            'created_at' => '2023-11-23',
            'updated_at' => '2023-11-23'
        ]);
        Review::create([
            'title' => 'Este restaurante tiene hambster de adorno de mesa.',
            'description' => 'Se la pasaron dando vueltitas en su ruedita :D',
            'user_id' => 2,
            'restaurant_id' => 1,
            'created_at' => '2023-11-22',
            'updated_at' => '2023-11-22'
        ]);

        Review::create([
            'title' => 'Esta curioso este restaurante',
            'description' => 'Hay hamsters en el centro de mesa jsjs',
            'user_id' => 2,
            'restaurant_id' => 1,
            'created_at' => '2023-11-21',
            'updated_at' => '2023-11-21'
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        if (!$user) {
            $user = User::factory()->create();
        }
        return [
            'user_id' => rand(1, 100),
            'title' => fake()->sentance(3),
            'description' => fake()->paragraph(),
            'image_path' => fake()->imageUrl(),
            'category' => fake()->randomElement(['Shoes', 'Clothes', 'Accessories']),
            'price' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement(['available', 'sold'])
        ];
    }
}

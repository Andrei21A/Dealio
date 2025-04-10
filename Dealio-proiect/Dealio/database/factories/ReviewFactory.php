<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('2023-01-01', 'now');
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        return [
            'product_id' => $product->id,
            'user_id' => $product->user_id,
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}

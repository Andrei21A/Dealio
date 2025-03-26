<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();

        return [
            'product_id' => $product->id,
            'user_id' => $product->user_id,
            'total_price' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}

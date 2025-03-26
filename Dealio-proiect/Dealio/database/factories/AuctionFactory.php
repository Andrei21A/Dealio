<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        if (!$product) {
            $product = Product::factory()->create();
        }
        $product = Product::factory()->create();
        return [
            'product_id' => $product->id,
            'user_id' => $product->user_id,
            'start_time' => now(),
            'end_time' => now()->addDays(rand(1, 7)),
            'starting_price' => fake()->randomFloat(2, 10, 1000),
            'highest_bid' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}

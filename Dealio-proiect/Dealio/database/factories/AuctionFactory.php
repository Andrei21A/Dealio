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
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $startingPrice = fake()->randomFloat(2, 10, 1000);
        $createdAt = fake()->dateTimeBetween('2023-01-01', 'now');
        return [
            'product_id' => $product->id,
            'user_id' => $product->user_id,
            'start_time' => now(),
            'end_time' => now()->addDays(rand(1, 7)),
            'starting_price' => $startingPrice,
            'highest_bid' => fake()->randomFloat(2, $startingPrice, $startingPrice * 1.5),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}

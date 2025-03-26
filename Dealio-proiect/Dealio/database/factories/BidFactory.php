<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        $auction = Auction::where('product_id', $product->id)->first();
        if (!$auction) {
            $auction = Auction::factory()->create(['product_id' => $product->id, 'user_id' => $product->user_id]);
        }
        return [
            'user_id' => $product->user_id,
            'product_id' => $product->id,
            'auction_id' => $auction->id,
            'amount' => fake()->randomFloat(2, 10, 1000),
            'bid_time' => now(),
        ];
    }
}

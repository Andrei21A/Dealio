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
        $auction = Auction::inRandomOrder()->first() ?? Auction::factory()->create();
        return [
            'user_id' => $auction->user_id,
            'product_id' => $auction->id,
            'auction_id' => $auction->id,
            'amount' => fake()->randomFloat(2, 10, 1000),
            'bid_time' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

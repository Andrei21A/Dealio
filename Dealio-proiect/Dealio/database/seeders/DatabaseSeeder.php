<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->admin()->create();
        User::factory(15)->seller()->create();
        User::factory(80)->regularUser()->create();
        
        Product::factory(200)->create();
        
        $productsWithAuctions = Product::inRandomOrder()
            ->take(50)
            ->get();
            
        $productsWithAuctions->each(function ($product) {
            Auction::factory()->create([
                'product_id' => $product->id,
                'user_id' => $product->user_id
            ]);
        });
        
        Auction::each(function ($auction) {
            Bid::factory(rand(0, 10))->create([
                'auction_id' => $auction->id,
                'product_id' => $auction->product_id,
                'user_id' => User::where('id', '!=', $auction->user_id)
                    ->inRandomOrder()
                    ->first()
                    ->id
            ]);
            

            $highestBid = $auction->bids()->max('amount');
            if ($highestBid) {
                $auction->update(['highest_bid' => $highestBid]);
            }
        });
        
        Product::inRandomOrder()
            ->take(100)
            ->each(function ($product) {
                Review::factory(rand(1, 5))->create([
                    'product_id' => $product->id,
                    'user_id' => User::where('id', '!=', $product->user_id)
                        ->inRandomOrder()
                        ->first()
                        ->id
                ]);
            });
        
        Order::factory(50)->create();
        
        User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);
        
        User::factory()->create([
            'email' => 'seller@example.com',
            'role' => 'seller'
        ]);
        
        User::factory()->create([
            'email' => 'user@example.com',
            'role' => 'user'
        ]);
    }
}

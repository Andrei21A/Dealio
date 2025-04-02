<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Auction extends Model
{

    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'start_time',
        'end_time',
        'starting_price',
        'highest_bid',
    ];


    public function scopeHighestBid(Builder $querry): Builder
    {
        return $querry->orderBy('highest_bid', 'desc');
    }

    public function scopeNumberOfBids(Builder $querry): Builder
    {
        return $querry->withCount('bids');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

}

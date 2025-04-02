<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'price',
        'status',
        'user_id'
    ];


    public function scopeNrOfReviews(Builder $query, $id): Builder
    {
        return $query->where('id', $id)
            ->withCount('reviews');
    }

    public function scopeMostReviews(Builder $querry): Builder
    {
        return $querry->withCount('reviews')
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeMostRated(Builder $querry): Builder
    {
        return $querry->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeAvailable(Builder $querry): Builder
    {
        return $querry->where('status', 'available');
    }

    public function scopePopular(Builder $querry, $from = null, $to = null): Builder
    {
        return $querry->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
            ->orderBy('reviews_count', 'desc');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auctions(): HasOne
    {
        return $this->hasOne(Auction::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    private function dateRangeFilter(Builder $querry, $from = null, $to = null)
    {
        if ($from && !$to) {
            $querry->where('created_at', '>=', $from);
        } else if (!$from && $to) {
            $querry->where('created_at', '<=', $to);
        } else if ($from && $to) {
            $querry->whereBetween('created_at', [$from, $to]);
        }
    }

}

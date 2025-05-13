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
        'location',
        'image_path',
        'category',
        'price',
        'status',
        'auction_status',
        'user_id'
    ];


    public function scopeNrOfReviews(Builder $query, $id): Builder
    {
        return $query->where('id', $id)
            ->withCount('reviews');
    }

    public function scopeTitle(Builder $query, $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeMostReviews(Builder $query): Builder
    {
        return $query->withCount('reviews')
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeMostRated(Builder $query): Builder
    {
        return $query->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeElectronics(Builder $query): Builder
    {
        return $query->where('category', 'Electronics');
    }

    public function scopeClothing(Builder $query): Builder
    {
        return $query->where('category', 'Clothing');
    }

    public function scopeFurniture(Builder $query): Builder
    {
        return $query->where('category', 'Furniture');
    }

    public function scopeLaptopsPhones(Builder $query): Builder
    {
        return $query->where('category', 'Laptops/Phones');
    }

    public function scopeBooks(Builder $query): Builder
    {
        return $query->where('category', 'Books');
    }

    public function scopeToys(Builder $query): Builder
    {
        return $query->where('category', 'Toys');
    }

    public function scopeSport(Builder $query): Builder
    {
        return $query->where('category', 'Sport');
    }

    public function scopeBeauty(Builder $query): Builder
    {
        return $query->where('category', 'Beauty');
    }

    public function scopeOther(Builder $query): Builder
    {
        return $query->where('category', 'Other');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])
            ->orderBy('reviews_count', 'desc');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
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

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } else if (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } else if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

}

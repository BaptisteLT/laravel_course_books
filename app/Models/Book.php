<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['author', 'title'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder|QueryBuilder
    {
        return $query->where('title', 'LIKE', '%'.$title.'%');
    }



    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount(['reviews' => function(Builder $query) use ($from, $to){
            $this->dateRangeFilter($query, $from, $to);
        }])
        ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg(
            ['reviews' => function(Builder $query) use ($from, $to){
                        $this->dateRangeFilter($query, $from, $to);
            }], 'rating')  
            ->orderBy('reviews_avg_rating', 'desc');
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        $query->when($from, function (Builder $query) use ($from) {
            $query->where('created_at', '>', $from);
        })
        ->when($to, function (Builder $query) use ($to) {
            $query->where('created_at', '<', $to);
        });
    }

    public function scopeMinReviews(Builder $query, int $minAmount): Builder|QueryBuilder
    {
        return $query->having('reviews_count','>=',$minAmount);
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(),now())
            ->highestRated(now()->subMonth(),now())
            ->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(6),now())
            ->highestRated(now()->subMonth(6),now())
            ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(),now())
            ->popular(now()->subMonth(),now())
            ->minReviews(2);
    }

    public function scopeHighestRatedLast6Months(Builder $query): Builder|QueryBuilder
    {
        return $query->highestRated(now()->subMonth(6),now())
            ->popular(now()->subMonth(6),now())
            ->minReviews(2);
    }
}

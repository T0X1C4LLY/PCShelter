<?php

namespace App\Models;

use App\Enums\ReviewCategory;
use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Game extends Model
{
    use HasFactory;
    use TraitUuid;

    public $timestamps = false;

    protected $casts = [
      'genres' => 'array',
      'categories' => 'array',
      'release_date' => 'array',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function reviewResults(): array
    {
        $keys = ReviewCategory::allValues();

        $reviews = $this->reviews()->get()->toArray();

        $reviewResults = [];

        foreach ($keys as $key) {
            $reviewResults[$key] = 0;
        }

        if (count($reviews) === 0) {
            return [
                'reviews' => $reviewResults,
                'all' => count($reviews)
            ];
        }

        /** @var array{
         *     atmosphere: int,
         *     child-friendly: int,
         *     difficulty: int,
         *     general: int,
         *     gore: int,
         *     graphic: int,
         *     music: int,
         *     NSFW: int,
         *     pleasure: int,
         *     relaxation: int,
         *     storyline: int,
         *     unique: int,
         *     } $review
         */
        foreach ($reviews as $review) {
            foreach ($keys as $key) {
                $reviewResults[$key] += $review[$key];
            }
        }

        foreach ($keys as $key) {
            $reviewResults[$key] /= count($reviews);
        }

        return [
            'reviews' => $reviewResults,
            'all' => count($reviews)
        ];
    }

    public function getBestAndGeneralReviews(): array
    {
        $reviews = $this->reviewResults();

        $best = array_search(max($reviews['reviews']), $reviews['reviews'], true);

        return [
            'best' => [
                'name' => $best,
                'score' => round($reviews['reviews'][$best], 2),
            ],
            'general' => round($reviews['reviews']['general'], 2),
            'allReviews' => $reviews['all'],
        ];
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    /** @var string $searchAsString */
                    $searchAsString = $search;

                    return $query->where('name', 'ilike', '%' . $searchAsString . '%');
                }
            )
        );
    }

    public function scopeFilterForGameFinder(Builder $query, array $filters): void
    {
        $query->when(
            $filters['genre'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    $query->whereJsonContains('genres', $search[0]);

                    for($i = 1, $iMax = count($search); $i < $iMax; $i++) {
                        $query->orWhereJsonContains('genres', $search[$i]);
                    }
                    return $query;
                }
            )
        );

        $query->when(
            $filters['category'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    $query->whereJsonContains('categories', $search[0]);

                    for($i = 1, $iMax = count($search); $i < $iMax; $i++) {
                        $query->orWhereJsonContains('categories', $search[$i]);
                    }
                    return $query;
                }
            )
        );
    }
}

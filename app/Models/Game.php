<?php

namespace App\Models;

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
}

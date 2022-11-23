<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search']['search'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    /** @var string $searchAsString */
                    $searchAsString = $search;

                    return $query->where('comments.body', 'like', '%' . $searchAsString . '%');
                }
            )
        );

        $query->when(
            $filters['id'] ?? false,
            function (Builder $query, mixed $author): Builder {
                /** @var string $authorAsString */
                $authorAsString = $author;

                return $query->whereHas(
                    'author',
                    fn (Builder $query): Builder => $query->where(
                        'comments.user_id',
                        strtolower($authorAsString)
                    ),
                );
            }
        );
    }
}

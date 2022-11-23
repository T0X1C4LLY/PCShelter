<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at'  => 'date:Y-m-d h:i:s',
    ];

    protected $fillable = ['title', 'excerpt', 'body'];

    /**
     * @var string[]
     */
    protected $with = ['category', 'author'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['admin_search'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    /** @var string $searchAsString */
                    $searchAsString = $search;

                    return $query->where('title', 'ilike', '%' . $searchAsString . '%');
                }
            )
        );

        $query->when(
            $filters['search'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    /** @var string $searchAsString */
                    $searchAsString = $search;

                    return $query->where('title', 'ilike', '%' . $searchAsString . '%')
                        ->orWhere('body', 'ilike', '%' . $searchAsString . '%');
                }
            )
        );

        $query->when(
            $filters['category'] ?? false,
            fn (Builder $query, mixed $category): Builder =>
            $query->whereHas(
                'category',
                fn (Builder $query): Builder =>
                $query->where('slug', $category)
            )
        );

        $query->when(
            $filters['author'] ?? false,
            function (Builder $query, mixed $author): Builder {
                /** @var string $authorAsString */
                $authorAsString = $author;

                return $query->whereHas(
                    'author',
                    fn (Builder $query): Builder => $query->where('username', strtolower($authorAsString)),
                );
            }
        );
    }

    public function scopeFilterForCreator(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search']['search'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    /** @var string $searchAsString */
                    $searchAsString = $search;
                    return $query->where('title', 'ilike', '%' . $searchAsString . '%');
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
                    fn (Builder $query): Builder => $query->where('posts.user_id', strtolower($authorAsString)),
                );
            }
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtAttribute(string $created_at): Carbon
    {
        return new Carbon($created_at);
    }
}

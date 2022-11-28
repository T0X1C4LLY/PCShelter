<?php

declare(strict_types=1);

namespace App\ValueObjects;

class FinderParams
{
    public readonly array $filters;

    /**
     * @param string[] $genres
     * @param string[] $categories
     * @param string[] $types
     */
    public function __construct(
        array $genres,
        array $categories,
        public readonly array $types,
    ) {
        $filters = [];

        if (!in_array('all', $genres, true)) {
            $filters['genre'] = $genres;
        }

        if (!in_array('all', $categories, true)) {
            $filters['category'] = $categories;
        }

        $this->filters = $filters;
    }
}

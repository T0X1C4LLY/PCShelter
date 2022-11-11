<?php

declare(strict_types=1);

namespace App\Other;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ArrayPagination
{
    public function paginate(array $items, string $path, int $perPage): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage() ?: 1;
        $items = Collection::make($items);

        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page
        );

        return $paginator->setPath($path);
    }
}

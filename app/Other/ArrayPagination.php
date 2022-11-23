<?php

declare(strict_types=1);

namespace App\Other;

use App\ValueObjects\PaginationInfo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArrayPagination
{
    public function paginate(array $items, PaginationInfo $pagination): LengthAwarePaginator
    {
        $collection = Collection::make($items);

        $paginator = new LengthAwarePaginator(
            $collection,
            $pagination->total,
            $pagination->page->perPage,
            $pagination->page->perPage
        );
        $paginator->setPath(url()->current());
        $paginator->onEachSide(1);

        return $paginator;
    }
}

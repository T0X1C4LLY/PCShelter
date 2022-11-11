<?php

declare(strict_types=1);

namespace App\Other;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArrayPagination
{
    public function paginate(array $arrayItems, int $total, int $page, int $perPage): LengthAwarePaginator
    {
        $items = Collection::make($arrayItems);

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page
        );
        $paginator->setPath(url()->current());
        $paginator->onEachSide(1);

        return $paginator;
    }
}

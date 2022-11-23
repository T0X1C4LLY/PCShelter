<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidPaginationInfoException;

class PaginationInfo
{
    public readonly Page $page;
    public readonly int $total;

    /**
     * @throws InvalidPaginationInfoException
     */
    public function __construct(
        Page $page,
        int $total,
    ) {
        if ($total < 0) {
            throw InvalidPaginationInfoException::byInvalidArgument();
        }

        $this->page = $page;
        $this->total = $total;
    }
}

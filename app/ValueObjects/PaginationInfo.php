<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidPaginationInfoException;

class PaginationInfo
{
    public readonly int $total;

    /**
     * @throws InvalidPaginationInfoException
     */
    public function __construct(
        public readonly Page $page,
        int $total,
    ) {
        if ($total < 0) {
            throw InvalidPaginationInfoException::byInvalidArgument();
        }

        $this->total = $total;
    }
}

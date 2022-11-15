<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidPaginationInfoException;

class PaginationInfo
{
    public readonly int $page;
    public readonly int $perPage;

    /**
     * @throws InvalidPaginationInfoException
     */
    public function __construct(
        int $page,
        int $perPage,
    ) {
        if ($page <= 0 || $perPage <= 0) {
            throw InvalidPaginationInfoException::byInvalidArgument();
        }

        $this->page = $page;
        $this->perPage = $perPage;
    }
}

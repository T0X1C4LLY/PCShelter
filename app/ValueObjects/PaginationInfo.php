<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidPaginationInfo;

class PaginationInfo
{
    public readonly int $page;
    public readonly int $perPage;

    /**
     * @throws InvalidPaginationInfo
     */
    public function __construct(
        int $page,
        int $perPage,
    ) {
        if ($page <= 0 || $perPage <= 0) {
            throw InvalidPaginationInfo::byInvalidArgument();
        }

        $this->page = $page;
        $this->perPage = $perPage;
    }
}

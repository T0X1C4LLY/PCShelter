<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidPaginationInfoException;

class Page
{
    public readonly int $pageNumber;
    public readonly int $perPage;

    /**
     * @throws InvalidPaginationInfoException
     */
    public function __construct(
        int $pageNumber,
        int $perPage,
    ) {
        if ($pageNumber <= 0 || $perPage <= 0) {
            throw InvalidPaginationInfoException::byInvalidArgument();
        }

        $this->pageNumber = $pageNumber;
        $this->perPage = $perPage;
    }

    public function skip(): int
    {
        return ($this->pageNumber - 1) * $this->perPage;
    }
}

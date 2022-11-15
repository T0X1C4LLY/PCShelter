<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidOrderArgumentException;

class AdminPostsOrderBy
{
    public readonly string $order;
    public readonly string $by;

    /**
     * @throws InvalidOrderArgumentException
     */
    public function __construct(
        string $order,
        string $by,
    ) {
        if ($order !== 'ASC' && $order !== 'DESC') {
            throw InvalidOrderArgumentException::byInvalidArgument($order, $by);
        }

        if ($by !== 'title' && $by !== 'comments' && $by !== 'created_at') {
            throw InvalidOrderArgumentException::byInvalidArgument($order, $by);
        }

        $this->order = $order;
        $this->by = $by;
    }
}

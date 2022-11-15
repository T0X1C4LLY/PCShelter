<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidOrderArgumentException;

class AdminUsersOrderBy
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

        if ($by !== 'username' && $by !== 'name' && $by !== 'created_at') {
            throw InvalidOrderArgumentException::byInvalidArgument($order, $by);
        }

        $this->order = $order;
        $this->by = $by;
    }
}

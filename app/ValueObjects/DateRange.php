<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Exceptions\InvalidDataRangeException;
use DateTimeImmutable;

class DateRange
{
    public readonly ?DateTimeImmutable $from;
    public readonly ?DateTimeImmutable $to;

    /**
     * @throws InvalidDataRangeException
     */
    public function __construct(
        string $from,
        string $to,
    ) {
        /** @var DateTimeImmutable|false $fromAsDate */
        $fromAsDate = DateTimeImmutable::createFromFormat('Y', $from);

        if ($fromAsDate) {
            $fromAsDate = $fromAsDate->modify('January 1 00:00:00');
        }

        /** @var DateTimeImmutable|false $fromAsDate */
        $toAsDate = DateTimeImmutable::createFromFormat('Y', $to);

        if ($toAsDate) {
            $toAsDate = $toAsDate->modify('January 1 00:00:00');
        }

        if ($fromAsDate && $toAsDate && $fromAsDate > $toAsDate) {
            throw InvalidDataRangeException::byDataRange($from, $to);
        }

        $this->from = $fromAsDate ?: null;
        $this->to = $toAsDate ?: null;
    }
}

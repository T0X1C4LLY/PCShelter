<?php

declare(strict_types=1);

namespace App\ValueObjects;

use DateTimeImmutable;

class DateRange
{
    public readonly DateTimeImmutable $from;
    public readonly DateTimeImmutable $to;

    public function __construct(
        ?string $from,
        ?string $to,
    ) {
        $fromAsDate = new DateTimeImmutable('January 1 1950 00:00:00');

        if ($from) {
            /** @var DateTimeImmutable $fromAsDate */
            $fromAsDate = DateTimeImmutable::createFromFormat('Y', $from);
            $fromAsDate = $fromAsDate->modify('January 1 00:00:00');
        }

        $toAsDate = new DateTimeImmutable();

        if ($to) {
            /** @var DateTimeImmutable $toAsDate */
            $toAsDate = DateTimeImmutable::createFromFormat('Y', $to);
            $toAsDate = $toAsDate->modify('January 1 00:00:00');
        }

        $this->from = $fromAsDate;
        $this->to = $toAsDate;
    }

    public function isInRange(DateTimeImmutable $date): bool
    {
        return $date >= $this->from && $date <= $this->to;
    }
}

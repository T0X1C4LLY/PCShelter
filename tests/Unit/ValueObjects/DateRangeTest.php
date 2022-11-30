<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\DateRange;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    /** @dataProvider datesProvider */
    public function test_DateRange_has_proper_dates(
        ?string $from,
        ?string $to,
        DateTimeImmutable $expectedFrom,
        DateTimeImmutable $expectedTo,
    ): void {
        $dateRange = new DateRange($from, $to);

        self::assertEquals($dateRange->from, $expectedFrom);
        self::assertEquals($dateRange->to->format('Y-m-d'), $expectedTo->format('Y-m-d'));
    }

    public function datesProvider(): array
    {
        return [
            [
                null,
                null,
                new DateTimeImmutable('January 1 1950 00:00:00'),
                new DateTimeImmutable(),
            ],
            [
                null,
                '1985',
                new DateTimeImmutable('January 1 1950 00:00:00'),
                new DateTimeImmutable('January 1 1985 00:00:00'),
            ],
            [
                '1985',
                null,
                new DateTimeImmutable('January 1 1985 00:00:00'),
                new DateTimeImmutable(),
            ],
            [
                '2020',
                '2021',
                new DateTimeImmutable('January 1 2020 00:00:00'),
                new DateTimeImmutable('January 1 2021 00:00:00'),
            ],
        ];
    }

    /** @dataProvider rangeAndDateProvider */
    public function test_if_date_isInRange(DateRange $range, DateTimeImmutable $date, bool $shouldBeInRange): void
    {
        self::assertSame($shouldBeInRange, $range->isInRange($date));
    }

    public function rangeAndDateProvider(): array
    {
        return [
            [
                new DateRange('2000', '2020'),
                new DateTimeImmutable(),
                false
            ],
            [
                new DateRange('2000', '2020'),
                new DateTimeImmutable('January 1 2000 00:00:00'),
                true
            ],
            [
                new DateRange('2000', '2020'),
                new DateTimeImmutable('January 1 2020 00:00:00'),
                true
            ],
            [
                new DateRange('2000', '2020'),
                new DateTimeImmutable('January 1 1999 00:00:00'),
                false
            ],
            [
                new DateRange('2000', '2020'),
                new DateTimeImmutable('January 1 2010 00:00:00'),
                true
            ],
        ];
    }
}

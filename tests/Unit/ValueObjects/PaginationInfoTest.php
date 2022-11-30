<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidPaginationInfoException;
use App\ValueObjects\DateRange;
use App\ValueObjects\Page;
use App\ValueObjects\PaginationInfo;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PaginationInfoTest extends TestCase
{
    /** @dataProvider paginationInfoProvider */
    public function test_PaginationInfo_can_be_created(
        Page $page,
        int $total,
    ): void
    {
        static::assertNotNull(new PaginationInfo($page, $total));
    }

    public function paginationInfoProvider(): array
    {
        return [
            [
                new Page(1 ,1), 2
            ],
            [
                new Page(1 ,1), 3
            ],
            [
                new Page(1 ,1), 90
            ],
        ];
    }

    /** @dataProvider incorrectDataProvider */
    public function test_InvalidPaginationInfoException_will_be_thrown(
        Page $page,
        int $total,
    ): void
    {
        $this->expectException(InvalidPaginationInfoException::class);

        new PaginationInfo($page, $total);
    }

    public function incorrectDataProvider(): array
    {
        return [
            [
                new Page(1 ,1), -1
            ],
            [
                new Page(1 ,1), -100
            ],
        ];
    }
}

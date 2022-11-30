<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidPaginationInfoException;
use App\ValueObjects\DateRange;
use App\ValueObjects\Page;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    /** @dataProvider pageInfoProvider */
    public function test_Page_can_be_created(
        int $pageNumber,
        int $perPage,
    ): void {
        static::assertNotNull(new Page($pageNumber, $perPage));
    }

    public function pageInfoProvider(): array
    {
        return [
            [
                1, 2
            ],
            [
                2, 3
            ],
            [
                10, 90
            ],
        ];
    }

    /** @dataProvider incorrectDataProvider */
    public function test_InvalidPaginationInfoException_will_be_thrown(
        int $pageNumber,
        int $perPage,
    ): void {
        $this->expectException(InvalidPaginationInfoException::class);

        new Page($pageNumber, $perPage);
    }

    public function incorrectDataProvider(): array
    {
        return [
            [
                0, 1
            ],
            [
                1, 0
            ],
            [
                -1, 10
            ],
            [
                11, -10
            ],
        ];
    }
}

<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\FinderParams;
use PHPUnit\Framework\TestCase;

class FinderParamsTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function test_finderParameters(
        array $genres,
        array $categories,
        array $types,
        array $filters
    ): void
    {
        $finderParams = new FinderParams($genres, $categories, $types);

        self::assertSame($filters, $finderParams->filters);
    }

    public function dataProvider(): array
    {
        return [
            [
                ['all'],
                ['all'],
                ['general'],
                [],
            ],
            [
                ['action', 'all'],
                ['MMO', 'all'],
                ['general'],
                [],
            ],
            [
                ['action', 'racing'],
                ['all'],
                ['general'],
                ['genre' => ['action', 'racing']],
            ],
            [
                ['all'],
                ['MMO', 'PvP'],
                ['general'],
                ['category' => ['MMO', 'PvP']],
            ],
            [
                ['action', 'racing', 'sports'],
                ['MMO', 'PvP', 'Co-op'],
                ['general'],
                ['genre' => ['action', 'racing', 'sports'], 'category' => ['MMO', 'PvP', 'Co-op']],
            ],
        ];
    }
}

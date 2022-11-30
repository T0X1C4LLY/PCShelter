<?php

namespace Tests\Unit\Steam;

use App\Steam\Library;
use App\Steam\MyGame;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
    private readonly Library $library;

    protected function setUp(): void
    {
        parent::setUp();

        $this->library = Library::fromArray([
            'game_count' => 3,
            'games' => [
                [
                    'appid' => 123456,
                    'name' => 'Best Game Ever',
                    'playtime_forever' => 140,
                    'img_icon_url' => 'img.png',
                    'has_community_visible_stats' => true,
                    'playtime_windows_forever' => 140,
                    'playtime_mac_forever' => 0,
                    'playtime_linux_forever' => 0,
                    'rtime_last_played' => 3,
                ],
                [
                    'appid' => 1234567,
                    'name' => 'Best Game Ever 2',
                    'playtime_forever' => 1,
                    'img_icon_url' => 'img2.png',
                    'has_community_visible_stats' => true,
                    'playtime_windows_forever' => 1,
                    'playtime_mac_forever' => 0,
                    'playtime_linux_forever' => 0,
                    'rtime_last_played' => 1,
                ],
                [
                    'appid' => 12345678,
                    'name' => 'Best Game Ever 3',
                    'playtime_forever' => 0,
                    'img_icon_url' => 'img2.png',
                    'has_community_visible_stats' => true,
                    'playtime_windows_forever' => 0,
                    'playtime_mac_forever' => 0,
                    'playtime_linux_forever' => 0,
                    'rtime_last_played' => 0,
                ]
            ]
        ]);
    }

    /** @dataProvider gameProvider */
    public function test_isInLibrary_works(string $gameName, bool $shouldBeInLibrary): void
    {
        self::assertSame($shouldBeInLibrary, $this->library->isInLibrary($gameName));
    }

    public function gameProvider(): array
    {
        return [
            [
                'Best Game Ever', true
            ],
            [
                'Best Game Ever 2', true
            ],
            [
                'Best Game Ever 4', false
            ]
        ];
    }

    /** @dataProvider gameAndNamesProvider */
    public function test_getByName_works(string $gameName, MyGame $game): void
    {
        self::assertEquals($game, $this->library->getByName($gameName));
    }

    public function gameAndNamesProvider(): array
    {
        return [
            [
                'Best Game Ever',
                MyGame::fromArray([
                    'appid' => 123456,
                    'name' => 'Best Game Ever',
                    'playtime_forever' => 140,
                    'img_icon_url' => 'img.png',
                    'has_community_visible_stats' => true,
                    'playtime_windows_forever' => 140,
                    'playtime_mac_forever' => 0,
                    'playtime_linux_forever' => 0,
                    'rtime_last_played' => 3,
                ])
            ],
            [
                'Best Game Ever 2',
                MyGame::fromArray([
                    'appid' => 1234567,
                    'name' => 'Best Game Ever 2',
                    'playtime_forever' => 1,
                    'img_icon_url' => 'img2.png',
                    'has_community_visible_stats' => true,
                    'playtime_windows_forever' => 1,
                    'playtime_mac_forever' => 0,
                    'playtime_linux_forever' => 0,
                    'rtime_last_played' => 1,
                ])
            ],
            [
                'Best Game Ever 3',
                MyGame::fromArray([
                    'appid' => 12345678,
                    'name' => 'Best Game Ever 3',
                    'playtime_forever' => 0,
                    'img_icon_url' => 'img2.png',
                    'has_community_visible_stats' => true,
                    'playtime_windows_forever' => 0,
                    'playtime_mac_forever' => 0,
                    'playtime_linux_forever' => 0,
                    'rtime_last_played' => 0,
                ])
            ]
        ];
    }
}

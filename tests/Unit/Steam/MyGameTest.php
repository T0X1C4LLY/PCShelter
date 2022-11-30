<?php

namespace Tests\Unit\Steam;

use App\Steam\MyGame;
use PHPUnit\Framework\TestCase;

class MyGameTest extends TestCase
{
    private readonly MyGame $game;
    private readonly MyGame $secondGame;
    private readonly MyGame $newGame;

    protected function setUp(): void
    {
        parent::setUp();

        $this->game = MyGame::fromArray([
            'appid' => 123456,
            'name' => 'Best Game Ever',
            'playtime_forever' => 140,
            'img_icon_url' => 'img.png',
            'has_community_visible_stats' => true,
            'playtime_windows_forever' => 140,
            'playtime_mac_forever' => 0,
            'playtime_linux_forever' => 0,
            'rtime_last_played' => 3,
        ]);

        $this->secondGame = MyGame::fromArray([
            'appid' => 1234567,
            'name' => 'Best Game Ever 2',
            'playtime_forever' => 1,
            'img_icon_url' => 'img2.png',
            'has_community_visible_stats' => true,
            'playtime_windows_forever' => 1,
            'playtime_mac_forever' => 0,
            'playtime_linux_forever' => 0,
            'rtime_last_played' => 1,
        ]);

        $this->newGame = MyGame::fromArray([
            'appid' => 12345678,
            'name' => 'Best Game Ever 3',
            'playtime_forever' => 0,
            'img_icon_url' => 'img2.png',
            'has_community_visible_stats' => true,
            'playtime_windows_forever' => 0,
            'playtime_mac_forever' => 0,
            'playtime_linux_forever' => 0,
            'rtime_last_played' => 0,
        ]);
    }

    public function test_wasEverPlayed_works(): void
    {
        self::assertTrue($this->game->wasEverPlayed());
        self::assertTrue($this->secondGame->wasEverPlayed());
        self::assertFalse($this->newGame->wasEverPlayed());
    }
}

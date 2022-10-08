<?php

namespace App\Steam;

use Exception;
use JsonSerializable;

class Library implements JsonSerializable
{
    /**
     * @param int $gameCunt
     * @param MyGame[] $games
     */
    private function __construct(
        public readonly int $gameCunt,
        public readonly array $games,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['game_count'],
            array_map(static fn (array $game) => MyGame::fromArray($game), $data['games'])
        );
    }

    public function isInLibrary(string $gameName): bool
    {
        foreach ($this->games as $game) {
            if ($game->name === $gameName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function getByName(string $name): MyGame
    {
        $key = array_search($name, array_column($this->games, 'name'), true);

        return $this->games[$key];
    }

    public function jsonSerialize(): array
    {
        return [
            'game_cunt' => $this->gameCunt,
            'games' => array_map(static fn (MyGame $game) => $game->jsonSerialize(), $this->games),
        ];
    }
}

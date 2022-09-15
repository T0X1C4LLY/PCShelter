<?php

namespace App\Models\Steam;

use JsonSerializable;

class Library implements JsonSerializable
{
    private function __construct(
        public readonly int $gameCunt,
        public readonly array $games,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['game_count'],
            array_map(static fn (array $game) => Game::fromArray($game), $data['games'])
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

    public function jsonSerialize(): array
    {
        return [
            'game_cunt' => $this->gameCunt,
            'games' => array_map(static fn (Game $game) => $game->jsonSerialize(), $this->games),
        ];
    }
}

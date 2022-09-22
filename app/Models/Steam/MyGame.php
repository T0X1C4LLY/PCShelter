<?php

namespace App\Models\Steam;

use JsonSerializable;

class MyGame implements JsonSerializable
{
    private function __construct(
        public readonly int $appId,
        public readonly string $name,
        public readonly int $playtimeForever,
        public readonly string $imgIconUrl,
        public readonly bool $hasCommunityVisibleStats,
        public readonly int $playtimeWindowsForever,
        public readonly int $playtimeMacForever,
        public readonly int $playtimeLinuxForever,
        public readonly int $rtimeLastPlayed,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['appid'],
            $data['name'],
            $data['playtime_forever'],
            $data['img_icon_url'],
            $data['has_community_visible_stats'] ?? false,
            $data['playtime_windows_forever'],
            $data['playtime_mac_forever'],
            $data['playtime_linux_forever'],
            $data['rtime_last_played'],
        );
    }

    public function wasEverPlayed(): bool
    {
        return $this->playtimeForever > 0;
    }

    public function jsonSerialize(): array
    {
        return [
            'appid' => $this->appId,
            'name' => $this->name,
            'playtimeForever' => $this->playtimeForever,
            'imgIconUrl' => $this->imgIconUrl,
            'hasCommunityVisibleStats' => $this->hasCommunityVisibleStats,
            'playtimeWindowsForever' => $this->playtimeWindowsForever,
            'playtimeMacForever' => $this->playtimeMacForever,
            'playtimeLinuxForever' => $this->playtimeLinuxForever,
            'rtimeLastPlayed' => $this->rtimeLastPlayed,
        ];
    }
}

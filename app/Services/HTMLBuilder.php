<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\HTMLBuilder as HTMLBuilderInterface;

class HTMLBuilder implements HTMLBuilderInterface
{
    /**
     * @param array{
     *     steam_appid: string,
     *     header_image: string,
     *     name: string,
     * }[] $games
     */
    public function createGameDivs(array $games): string
    {
        $html = '';

        /** @var array{
         *     steam_appid: string,
         *     header_image: string,
         *     name: string,
         * } $game
         */
        foreach ($games as $game) {
            $html .= sprintf(
                '
                    <div class="px-2 py-2 transform transition duration-500 hover:scale-105">
                        <a href="/games/%s">
                            <img src="%s" alt="" title="%s" class="w-full h-full"/>
                        </a>
                    </div>
                ',
                $game['steam_appid'],
                $game['header_image'],
                $game['name']
            );
        }

        return $html;
    }
}

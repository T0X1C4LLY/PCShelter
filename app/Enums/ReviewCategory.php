<?php

declare(strict_types=1);

namespace App\Enums;

enum ReviewCategory: string
{
    case GENERAL = 'general';
    case MUSIC = 'music';
    case GRAPHIC = 'graphic';
    case ATMOSPHERE = 'atmosphere';
    case DIFFICULTY = 'difficulty';
    case STORYLINE = 'storyline';
    case RELAXATION = 'relaxation';
    case PLEASURE = 'pleasure';
    case CHILD_FRIENDLY = 'child-friendly';
    case NSFW = 'NSFW';
    case GORE = 'gore';
    case UNIQUE = 'unique';

    /**
     * @return string[]
     */
    public static function allValues(): array
    {
        return array_map(
            static fn (ReviewCategory $category) => $category->value,
            self::cases()
        );
    }
}

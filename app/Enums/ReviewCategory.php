<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\IsEnum;

enum ReviewCategory: string
{
    use IsEnum;

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
}

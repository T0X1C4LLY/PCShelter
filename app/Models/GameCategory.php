<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    use HasFactory;
    use TraitUuid;

    public $timestamps = false;

    public function getGames(): Collection
    {
        return Game::whereJsonContains('categories', $this['name'])->get();
    }
}

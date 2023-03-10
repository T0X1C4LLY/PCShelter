<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    use HasUuid;

    public $timestamps = false;

    public function getGames(): Collection
    {
        return Game::whereJsonContains('genres', $this['name'])->get();
    }
}

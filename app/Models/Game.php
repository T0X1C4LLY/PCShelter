<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;
    use TraitUuid;

    public $timestamps = false;

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}

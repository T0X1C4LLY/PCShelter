<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<array-key, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];
//    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<array-key, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<array-key, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUsernameAttribute(string $username): string
    { //Accessor
        return ucwords($username);
    }

//    public function setPasswordAttribute(string $password): void
//    { //Mutator: set + nazwa_atrybutu + Attribute()
//        $this->attributes['password'] = bcrypt($password);
//    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

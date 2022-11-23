<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Invisnik\LaravelSteamAuth\SteamInfo;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use TraitUuid;

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string',
        'created_at'  => 'date:Y-m-d h:i:s',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['admin_search'] ?? false,
            fn (Builder $query, mixed $search): Builder =>
            $query->where(
                function (Builder $query) use ($search): Builder {
                    /** @var string $searchAsString */
                    $searchAsString = $search;

                    return $query
                        ->where('username', 'like', '%' . $searchAsString . '%')
                        ->orWhere('users.name', 'like', '%' . $searchAsString . '%');
                }
            )
        );
    }

    public function updateAfterSteamLogin(SteamInfo $info): void
    {
        /** @var int $steamId */
        $steamId = $info->get('steamID64');

        /** @var string $avatar */
        $avatar = $info->get('avatarfull');

        /** @var string $steamUsername */
        $steamUsername = $info->get('personaname');

        $this->steamId = $steamId;
        $this->avatar = $avatar;
        $this->steamUsername = $steamUsername;

        $this->givePermissionTo('delete_steam_data');
        $this->revokePermissionTo("login_to_steam");
        $this->givePermissionTo('add_review');
        $this->save();
    }

    public function updateAfterSteamLogout(): void
    {
        $this->revokePermissionTo('delete_steam_data');
        $this->givePermissionTo("login_to_steam");
        $this->update([
            'steamUsername' => null,
            'avatar' => null,
            'steamId' => null,
        ]);
    }
}

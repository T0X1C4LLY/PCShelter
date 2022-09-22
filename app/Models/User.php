<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

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
    ];

//    public function getUsernameAttribute(string $username): string
//    { //Accessor
//        return ucwords($username);
//    }

//    public function setPasswordAttribute(string $password): void
//    { //Mutator: set + nazwa_atrybutu + Attribute()
//        $this->attributes['password'] = bcrypt($password);
//    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @throws Exception
     */
    public function getRole(): string
    {
        $roleId = DB::table('model_has_roles')->where('model_id', $this->id)->first('role_id');

        if (!$roleId) {
            throw new Exception('Expected ModelHasRoles, null appeared');
        }

        $roleIdAsString = (get_object_vars($roleId))['role_id'];

        /** @var string $role */
        $role = Role::where('id', $roleIdAsString)->value('name');

        if (!$role) {
            throw new Exception('Expected Role, null appeared');
        }

        return $role;
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
                        ->orWhere('name', 'like', '%' . $searchAsString . '%');
                }
            )
        );
    }
}

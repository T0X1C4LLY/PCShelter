<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\Creator as CreatorInterface;
use App\Services\Interfaces\Newsletter;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Creator implements CreatorInterface
{
    public function __construct(public readonly Newsletter $newsletter)
    {
    }

    /**
     * @param array{
     *     name: string,
     *     username: string,
     *     email: string,
     *     password: string,
     * } $userData
     */
    public function creatUser(array $userData): User
    {
        /** @var string $password */
        $password = $userData['password'];

        $user = User::create([
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole(Role::findByName('user'));

        $users = $this->newsletter->getAllSubscribers()->members;

        $key = array_search($user->email, array_column($users, 'email_address'), true);

        if ($key !== false) {
            $users[$key]->givePermissionTo('unsubscribe');
            $users[$key]->givePermissionTo('login_to_steam');
        }

        return $user;
    }
}

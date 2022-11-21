<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@admin.com',
            'steamUsername' => 'T0X1C4LLY',
            'avatar' => 'https://avatars.akamai.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg',
            'steamId' => 76561198395363470,
        ]);

        $user = User::factory()->create([
            'username' => 'user',
            'password' => Hash::make('user'),
            'email' => 'user@user.com',
        ]);

        $creator = User::factory()->create([
            'username' => 'creator',
            'password' => Hash::make('creator'),
            'email' => 'creator@creator.com',
        ]);

        $admin->assignRole(Role::findByName('admin'));
        $user->assignRole(Role::findByName('user'));
        $creator->assignRole(Role::findByName('creator'));

        $quantityOfCommonUsers = 34;
        $quantityOfCreators = 15;

        for ($i = 0; $i < $quantityOfCommonUsers; $i++) {
            /** @var Model $temp */
            $temp = User::factory()->create();
            $temp->assignRole(Role::findByName('user'));
            $temp->givePermissionTo(Permission::findByName('login_to_steam'));
        }

        for ($i = 0; $i < $quantityOfCreators; $i++) {
            /** @var Model $temp */
            $temp = User::factory()->create();
            $temp->assignRole(Role::findByName('creator'));
            $temp->givePermissionTo(Permission::findByName('login_to_steam'));
        }
    }
}

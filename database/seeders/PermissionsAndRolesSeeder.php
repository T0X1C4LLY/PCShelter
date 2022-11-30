<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \JsonException
     */
    public function run(): void
    {
        Permission::truncate();
        Role::truncate();

        $rolesAndPermissionsFile = file_get_contents(base_path()."/database/assets/rolesAndPermissions.json");

        $rolesAndPermissions = json_decode(
            $rolesAndPermissionsFile,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $permissions = $rolesAndPermissions['permissions'];
        $roles = $rolesAndPermissions['roles'];


        array_map(static function (string $permission): void {
            Permission::create(['name' => $permission]);
        }, array_keys($permissions));

        array_map(static function (string $role) {
            Role::create(['name' => $role]);
        }, $roles);

        array_map(static function (array $roles, string $permission) {
            array_map(static function (string $role) use ($permission) {
                (Role::findByName($role))->givePermissionTo($permission);
            }, $roles);
        }, $permissions, array_keys($permissions));
    }
}

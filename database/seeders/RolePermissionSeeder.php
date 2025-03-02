<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat daftar permission
        $permissions = [
            'create-user', 'update-user', 'delete-user', 'view-user',
            'create-article', 'update-article', 'delete-article', 'view-article'
        ];

        // Pastikan setiap permission hanya dibuat jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Buat role jika belum ada
        $roleAdministrator = Role::firstOrCreate(
            ['name' => 'administrator', 'guard_name' => 'web'],
             // Pastikan `team_id` ada
        );
        $roleCreator = Role::firstOrCreate(
            ['name' => 'creator', 'guard_name' => 'web'],
            // Pastikan `team_id` ada
        );
        // Berikan permission ke administrator
        $roleAdministrator->syncPermissions([
            'create-user', 'update-user', 'delete-user', 'view-user'
        ]);

        // Berikan permission ke creator
        $roleCreator->syncPermissions([
            'create-article', 'update-article', 'delete-article', 'view-article'
        ]);

        echo "✅ Role dan permission berhasil dibuat!\n";
    }
}

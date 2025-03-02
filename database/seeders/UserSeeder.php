<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role sudah ada
        $adminRole = Role::where('name', 'administrator')
            ->where('guard_name', 'web')
            ->first();
        $creatorRole = Role::where('name', 'creator')
            ->where('guard_name', 'web')
            ->first();

        if (!$adminRole || !$creatorRole) {
            echo "⚠️ Role administrator atau creator belum ada. Pastikan RolePermissionSeeder sudah dijalankan!\n";
            return;
        }

        // Buat user admin jika belum ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Berikan role admin dengan team_id
        if (!$admin->hasRole('administrator', 'web')) {
            $admin->assignRole($adminRole);
        }

        // Buat user creator jika belum ada
        $creator = User::firstOrCreate(
            ['email' => 'creator@creator.com'],
            [
                'name' => 'Creator',
                'password' => bcrypt('password'),
            ]
        );

        // Berikan role creator dengan team_id
        if (!$creator->hasRole('creator', 'web')) {
            $creator->assignRole($creatorRole);
        }

        echo "✅ User dan role berhasil dibuat!\n";
    }
}

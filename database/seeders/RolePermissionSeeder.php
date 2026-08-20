<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions (opsional, untuk kontrol lebih granular)
        // Contoh: Permission::create(['name' => 'edit articles']);

        // Buat Roles
        $adminRole = Role::create(['name' => 'admin']);
        $ownerRole = Role::create(['name' => 'owner']);
        $ownerRole = Role::create(['name' => 'user']);

        // Berikan semua permission yang ada (jika ada) ke admin
        // $adminRole->givePermissionTo(Permission::all());

        // Atau, Anda bisa memberikan permission spesifik ke role tertentu
        // Contoh: $ownerRole->givePermissionTo('view dashboard');
    }
}

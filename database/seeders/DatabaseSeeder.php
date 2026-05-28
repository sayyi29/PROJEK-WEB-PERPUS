<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'manage books']);
        Permission::create(['name' => 'manage borrowings']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'borrow books']);
        Permission::create(['name' => 'view reports']);

        // Create Roles and Assign Permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $petugasRole = Role::create(['name' => 'petugas']);
        $petugasRole->givePermissionTo(['manage books', 'manage borrowings', 'view reports']);

        $anggotaRole = Role::create(['name' => 'anggota']);
        $anggotaRole->givePermissionTo(['borrow books']);

        // Create Default Admin
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@perpus.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        // Create Default Anggota
        $anggota = User::factory()->create([
            'name' => 'Ahmad Anggota',
            'email' => 'ahmad@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $anggota->assignRole($anggotaRole);

        // Seed Categories
        Category::create(['name' => 'Teknologi', 'slug' => 'teknologi']);
        Category::create(['name' => 'Sains', 'slug' => 'sains']);
        Category::create(['name' => 'Sastra', 'slug' => 'sastra']);
        Category::create(['name' => 'Sejarah', 'slug' => 'sejarah']);
        Category::create(['name' => 'Agama', 'slug' => 'agama']);
    }
}

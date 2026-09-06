<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'read-invoices']);

        $role1 = Role::create(['name' => 'Admin']);
        $role1->givePermissionTo(Permission::all());
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $role2 = Role::create(['name' => 'Account']);
        $role2->givePermissionTo('read-invoices');

        // create admin user
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role1);

        // create account user
        $user = \App\Models\User::factory()->create([
            'name' => 'Accountant',
            'email' => 'Accountant@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role2);
 
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class AssignRolesSeeder extends Seeder
{
    public function run()
    {
        // Use the default guard from config
    
        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' =>"guard"]);
        $productManagerRole = Role::firstOrCreate(['name' => 'product_manager', 'guard_name' => "guard"]);
        $userManagerRole = Role::firstOrCreate(['name' => 'user_manager', 'guard_name' => "guard"]);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' =>"guard"]);

        // Create permissions
        $viewDashboard = Permission::firstOrCreate(['name' => 'view_dashboard', 'guard_name' => "guard"]);
        $viewCategories = Permission::firstOrCreate(['name' => 'view_categories', 'guard_name' => "guard"]);
        $createCategories = Permission::firstOrCreate(['name' => 'create_categories', 'guard_name' => "guard"]);
        $editCategories = Permission::firstOrCreate(['name' => 'edit_categories', 'guard_name' => "guard"]);
        $deleteCategories = Permission::firstOrCreate(['name' => 'delete_categories', 'guard_name' => "guard"]);

        $viewProducts = Permission::firstOrCreate(['name' => 'view_products', 'guard_name' => "guard"]);
        $createProducts = Permission::firstOrCreate(['name' => 'create_products', 'guard_name' => "guard"]);
        $editProducts = Permission::firstOrCreate(['name' => 'edit_products', 'guard_name' => "guard"]);
        $deleteProducts = Permission::firstOrCreate(['name' => 'delete_products', 'guard_name' => "guard"]);

        $viewUsers = Permission::firstOrCreate(['name' => 'view_users', 'guard_name' => "guard"]);
        $editUsers = Permission::firstOrCreate(['name' => 'edit_users', 'guard_name' => "guard"]);
        $deleteUsers = Permission::firstOrCreate(['name' => 'delete_users', 'guard_name' => "guard"]);

        // Assign permissions to roles
        $superAdminRole->syncPermissions([
            $viewDashboard,
            $viewCategories,
            $createCategories,
            $editCategories,
            $deleteCategories,
            $viewProducts,
            $createProducts,
            $editProducts,
            $deleteProducts,
            $viewUsers,
            $editUsers,
            $deleteUsers,
        ]);

        $productManagerRole->syncPermissions([
            $viewProducts,
            $createProducts,
            $editProducts,
            $deleteProducts,
        ]);

        $userManagerRole->syncPermissions([
            $viewUsers,
            $editUsers,
            $deleteUsers,
        ]);

        // Assign roles to users
        $users = User::all();

        $users->each(function ($user, $index) use ($superAdminRole, $userRole) {
            if ($index === 0) {
                $user->assignRole($superAdminRole);
                $this->command->info("Assigned 'super_admin' role to user: {$user->email}");
            } else {
                $user->assignRole($userRole);
                $this->command->info("Assigned 'user' role to user: {$user->email}");
            }
        });
    }
}
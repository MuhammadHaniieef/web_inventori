<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\Category;
use App\Models\Role;
use App\Models\ToolCategory;
use App\Models\User;
use App\Models\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // role
        $roles = ['admin', 'spv', 'staff'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // user
        $users = [
            ['name' => 'Admin', 'username' => 'adm', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin')],
            ['name' => 'Supervisor', 'username' => 'spv', 'email' => 'supervisor@gmail.com', 'password' => Hash::make('super')],
            ['name' => 'Staff', 'username' => 'staff', 'email' => 'staff@gmail.com', 'password' => Hash::make('staff')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // RoleUser
        $userRoles = [
            'admin@gmail.com' => 'admin',
            'supervisor@gmail.com' => 'spv',
            'staff@gmail.com' => 'staff',
        ];

        foreach ($userRoles as $email => $roleName) {
            $user = User::where('email', $email)->first();
            $role = Role::where('name', $roleName)->first();

            if ($user && $role) {
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Category::create([
            'name' => 'Micro',
            'description' => 'Barang-barang di micro',
        ]);
        
        ToolCategory::create([
            'name' => 'Obeng',
            'description' => 'wkwk',
        ]);

        Box::create([
            'code' => 'A001',
            'description' => 'CB Box',
            'position' => 'Z01',
            'detail_position' => 'Rak paling kiri di barisan kanan',
            'size' => 'medium',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

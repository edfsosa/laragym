<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $trainerRole = Role::firstOrCreate(['name' => 'Trainer']);
        $memberRole = Role::firstOrCreate(['name' => 'Member']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@laragym.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password')
            ]
        );
        $admin->assignRole($adminRole);

        // Create trainer user
        $trainer = User::firstOrCreate(
            ['email' => 'jdiaz@laragym.com'],
            [
                'name' => 'Juan Díaz',
                'password' => bcrypt('password')
            ]
        );
        $trainer->assignRole($trainerRole);

        // Create member user
        $member = User::firstOrCreate(
            ['email' => 'mgonzalez@laragym.com'],
            [
                'name' => 'María González',
                'password' => bcrypt('password')
            ]
        );
        $member->assignRole($memberRole);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}

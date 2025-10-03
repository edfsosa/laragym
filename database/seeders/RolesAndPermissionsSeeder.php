<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles básicos
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $trainerRole = Role::firstOrCreate(['name' => 'trainer']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);

        // Usuario Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@larafit.com'],
            [
                'name' => 'Administrador Larafit',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($adminRole);

        // Usuario Trainer
        $trainer = User::firstOrCreate(
            ['email' => 'trainer@larafit.com'],
            [
                'name' => 'Entrenador Demo',
                'password' => Hash::make('password'),
            ]
        );
        $trainer->assignRole($trainerRole);

        // Usuario Member
        $member = User::firstOrCreate(
            ['email' => 'member@larafit.com'],
            [
                'name' => 'Alumno Demo',
                'password' => Hash::make('password'),
            ]
        );
        $member->assignRole($memberRole);

        $this->command->info('Roles and users seeded successfully.');
    }
}

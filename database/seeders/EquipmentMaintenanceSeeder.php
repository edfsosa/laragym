<?php

namespace Database\Seeders;

use App\Models\EquipmentMaintenance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EquipmentMaintenance::factory()->count(20)->create();
    }
}

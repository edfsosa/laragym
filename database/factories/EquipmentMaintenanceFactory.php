<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentMaintenance>
 */
class EquipmentMaintenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = EquipmentMaintenance::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'in_progress', 'completed']);

        return [
            'equipment_id' => Equipment::inRandomOrder()->value('id') ?? Equipment::factory(),
            'type'         => $this->faker->randomElement(['preventive', 'corrective']),
            'title'        => $this->faker->sentence(3),
            'description'  => $this->faker->optional(0.6)->paragraph(),
            'status'       => $status,
            'performed_at' => $status === 'completed' ? $this->faker->dateTimeBetween('-60 days', 'now') : null,
            'next_due_at'  => $this->faker->optional(0.7)->dateTimeBetween('now', '+6 months'),
            'cost'         => $this->faker->optional(0.5)->randomFloat(2, 50000, 5000000),
            'vendor'       => $this->faker->optional(0.5)->company(),
        ];
    }
}

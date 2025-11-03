<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Equipment::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['cardio', 'strength', 'flexibility', 'balance', 'mobility', 'other']);
        $status = $this->faker->randomElement(['available', 'maintenance', 'out_of_order']);

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['Machine', 'Set', 'Device', 'Equipment']),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'type' => $type,
            'image_url' => $this->faker->optional(0.5)->imageUrl(640, 480, 'fitness', true),
            'video_url' => $this->faker->optional(0.5)->url(),
            'serial_number' => strtoupper($this->faker->bothify('SN-####-????')),
            'brand' => $this->faker->company(),
            'model' => strtoupper($this->faker->bothify('MDL-###-??')),
            'status' => $status,
            'purchased_at' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'purchase_price' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}

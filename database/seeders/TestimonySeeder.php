<?php

namespace Database\Seeders;

use App\Models\Testimony;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonies = [
            [
                'author_name' => 'José Mereles',
                'content' => 'El mejor gimnasio de Itauguá. Los entrenadores son excelentes y las instalaciones están siempre limpias. Bajé 15kg en 4 meses.',
            ],
            [
                'author_name' => 'María González',
                'content' => 'Me encanta venir aquí. La variedad de clases es increíble y siempre hay algo nuevo para probar. ¡Recomiendo 100%!',
            ],
            [
                'author_name' => 'Carlos López',
                'content' => 'El ambiente es muy amigable y motivador. Los entrenadores realmente se preocupan por tu progreso. He ganado mucha fuerza desde que empecé.',
            ],
        ];

        foreach ($testimonies as $testimony) {
            Testimony::create($testimony);
        }

        $this->command->info('Testimonies table seeded successfully.');
    }
}

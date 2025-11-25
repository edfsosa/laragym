<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = [
            // EQUIPOS DE CARDIO (7 equipos)
            [
                'name' => 'Cinta de Correr Comercial',
                'description' => 'Cinta de correr profesional con pantalla táctil LCD, programas preestablecidos, inclinación automática hasta 15%, velocidad máxima 20 km/h. Ideal para cardio intenso y entrenamiento de resistencia.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'LIFE-TREAD-001',
                'brand' => 'Life Fitness',
                'model' => 'Integrity DX',
                'status' => 'available',
                'purchased_at' => '2024-03-15',
                'purchase_price' => 73000000.00, // $10,000 x 7,300
            ],
            [
                'name' => 'Bicicleta Estática Vertical',
                'description' => 'Bicicleta estática vertical con resistencia magnética, 20 niveles de intensidad, monitor cardíaco integrado y múltiples programas de entrenamiento.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'PREC-BIKE-001',
                'brand' => 'Precor',
                'model' => 'UBK 885',
                'status' => 'available',
                'purchased_at' => '2024-04-20',
                'purchase_price' => 29200000.00, // $4,000 x 7,300
            ],
            [
                'name' => 'Bicicleta Reclinada',
                'description' => 'Bicicleta reclinada ergonómica con respaldo ajustable, ideal para usuarios con problemas de espalda. Resistencia electromagnética y programas cardiovasculares.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'MATRX-RECL-001',
                'brand' => 'Matrix',
                'model' => 'R50',
                'status' => 'available',
                'purchased_at' => '2024-04-20',
                'purchase_price' => 32850000.00, // $4,500 x 7,300
            ],
            [
                'name' => 'Elíptica Comercial',
                'description' => 'Máquina elíptica de bajo impacto con ajuste de inclinación y resistencia. Proporciona entrenamiento cardiovascular completo trabajando piernas y brazos simultáneamente.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'PREC-ELLIP-001',
                'brand' => 'Precor',
                'model' => 'EFX 885',
                'status' => 'available',
                'purchased_at' => '2024-05-10',
                'purchase_price' => 54750000.00, // $7,500 x 7,300
            ],
            [
                'name' => 'Máquina de Remo',
                'description' => 'Remo de aire con monitor de rendimiento PM5, calcula potencia, ritmo, calorías. Excelente para cardio de cuerpo completo y bajo impacto en articulaciones.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'CONC2-ROW-001',
                'brand' => 'Concept2',
                'model' => 'RowErg',
                'status' => 'available',
                'purchased_at' => '2024-06-05',
                'purchase_price' => 7227000.00, // $990 x 7,300
            ],
            [
                'name' => 'Escaladora StairMaster',
                'description' => 'Escaladora tipo escalera giratoria continua con 20 niveles de resistencia. Simula subida de escaleras real para cardio intenso y tonificación de piernas.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'STAIR-STEP-001',
                'brand' => 'StairMaster',
                'model' => '8 Gauntlet',
                'status' => 'available',
                'purchased_at' => '2024-06-15',
                'purchase_price' => 58400000.00, // $8,000 x 7,300
            ],
            [
                'name' => 'Bicicleta de Aire (Air Bike)',
                'description' => 'Bicicleta con resistencia de aire que aumenta con la intensidad. Ventilador dual, asiento ajustable, ideal para HIIT y entrenamientos CrossFit.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-AIR-001',
                'brand' => 'Rogue',
                'model' => 'Echo Bike V3.0',
                'status' => 'available',
                'purchased_at' => '2024-07-01',
                'purchase_price' => 5840000.00, // $800 x 7,300
            ],

            // EQUIPOS DE FUERZA - MÁQUINAS (8 equipos)
            [
                'name' => 'Prensa de Pecho (Chest Press)',
                'description' => 'Máquina selectorizada de press de pecho con stack de 100kg, movimiento convergente que simula el press con mancuernas. Asiento y respaldo ajustables.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'HAMR-CHEST-001',
                'brand' => 'Hammer Strength',
                'model' => 'Select Chest Press',
                'status' => 'available',
                'purchased_at' => '2024-03-20',
                'purchase_price' => 36500000.00, // $5,000 x 7,300
            ],
            [
                'name' => 'Jalón al Pecho (Lat Pulldown)',
                'description' => 'Máquina de jalón con polea alta, stack de 120kg, múltiples agarres para trabajar dorsales desde diferentes ángulos. Rodillos ajustables para fijación de piernas.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'LIFE-LAT-001',
                'brand' => 'Life Fitness',
                'model' => 'Signature Series',
                'status' => 'available',
                'purchased_at' => '2024-03-25',
                'purchase_price' => 32850000.00, // $4,500 x 7,300
            ],
            [
                'name' => 'Prensa de Piernas (Leg Press)',
                'description' => 'Leg press con plataforma de carga de discos de 45°, capacidad máxima 400kg. Respaldo reclinable y agarre lateral para seguridad.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'BODY-LEG-001',
                'brand' => 'Body-Solid',
                'model' => 'SLP500G',
                'status' => 'available',
                'purchased_at' => '2024-04-05',
                'purchase_price' => 29200000.00, // $4,000 x 7,300
            ],
            [
                'name' => 'Extensión de Cuádriceps',
                'description' => 'Máquina de extensión de piernas con stack de 100kg, rodillo acolchado ajustable, respaldo regulable en múltiples posiciones para aislamiento óptimo del cuádriceps.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'TECH-QUAD-001',
                'brand' => 'Technogym',
                'model' => 'Selection Pro',
                'status' => 'available',
                'purchased_at' => '2024-04-05',
                'purchase_price' => 27375000.00, // $3,750 x 7,300
            ],
            [
                'name' => 'Curl de Femoral Acostado',
                'description' => 'Máquina de femoral prone con stack de 90kg, rodillo de tobillo ajustable, diseño ergonómico que minimiza estrés lumbar durante el ejercicio.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'HAMR-HAM-001',
                'brand' => 'Hammer Strength',
                'model' => 'Select Prone Leg Curl',
                'status' => 'available',
                'purchased_at' => '2024-04-10',
                'purchase_price' => 29200000.00, // $4,000 x 7,300
            ],
            [
                'name' => 'Máquina Smith',
                'description' => 'Smith machine con barra guiada por rieles verticales, ganchos de seguridad cada 5cm, capacidad de carga 300kg. Incluye banco plano deslizable.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'BODY-SMTH-001',
                'brand' => 'Body-Solid',
                'model' => 'SCB1000',
                'status' => 'available',
                'purchased_at' => '2024-05-01',
                'purchase_price' => 25550000.00, // $3,500 x 7,300
            ],
            [
                'name' => 'Polea Cruzada Doble',
                'description' => 'Cable crossover con dos stacks de 90kg cada uno, poleas ajustables en altura de 0 a 2.4m. Estructura robusta de acero para ejercicios de pecho, espalda y core.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'HAMR-CABL-001',
                'brand' => 'Hammer Strength',
                'model' => 'HD Elite Cable Crossover',
                'status' => 'available',
                'purchased_at' => '2024-05-15',
                'purchase_price' => 54750000.00, // $7,500 x 7,300
            ],
            [
                'name' => 'Press de Hombros Sentado',
                'description' => 'Máquina de press militar con stack de 100kg, asiento ajustable con respaldo, movimiento convergente que respeta la biomecánica natural del hombro.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'LIFE-SHLDR-001',
                'brand' => 'Life Fitness',
                'model' => 'Signature Shoulder Press',
                'status' => 'maintenance',
                'purchased_at' => '2024-06-01',
                'purchase_price' => 32850000.00, // $4,500 x 7,300
            ],

            // EQUIPOS DE PESO LIBRE Y RACKS (8 equipos)
            [
                'name' => 'Jaula de Potencia (Power Rack)',
                'description' => 'Power rack profesional 2.4m altura, tubular de acero 75x75mm, sistema de seguridad con barras J-Hooks y spotter arms, capacidad 500kg. Incluye barra para dominadas.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-RACK-001',
                'brand' => 'Rogue',
                'model' => 'RM-6 Monster',
                'status' => 'available',
                'purchased_at' => '2024-02-10',
                'purchase_price' => 29200000.00, // $4,000 x 7,300
            ],
            [
                'name' => 'Banco Plano Olímpico',
                'description' => 'Banco plano con capacidad 400kg, superficie antideslizante, patas con gomas anti-vibración, altura estándar 43cm. Estructura reforzada para uso comercial.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'HAMR-BENCH-001',
                'brand' => 'Hammer Strength',
                'model' => 'Athletic Flat Bench',
                'status' => 'available',
                'purchased_at' => '2024-02-15',
                'purchase_price' => 3650000.00, // $500 x 7,300
            ],
            [
                'name' => 'Banco Ajustable FID',
                'description' => 'Banco ajustable en 7 posiciones (plano, inclinado y declinado), respaldo acolchado de alta densidad, capacidad 300kg, fácil ajuste con pin de liberación rápida.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'REP-ADJ-001',
                'brand' => 'REP Fitness',
                'model' => 'AB-5200',
                'status' => 'available',
                'purchased_at' => '2024-02-15',
                'purchase_price' => 5840000.00, // $800 x 7,300
            ],
            [
                'name' => 'Set de Mancuernas Hexagonales',
                'description' => 'Set completo de mancuernas de goma hexagonales desde 5lb hasta 50lb (10 pares), cabezales con recubrimiento de goma para protección del piso. Incluye rack de 3 niveles.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'BODY-DUMB-SET1',
                'brand' => 'Body-Solid',
                'model' => 'Rubber Hex Set 5-50lb',
                'status' => 'available',
                'purchased_at' => '2024-02-20',
                'purchase_price' => 14600000.00, // $2,000 x 7,300
            ],
            [
                'name' => 'Barra Olímpica 20kg',
                'description' => 'Barra olímpica profesional 20kg/45lb, 2.2m longitud, acabado en zinc, marcas de knurling IPF, rodamientos de agujas, capacidad 600kg. Ideal para powerlifting y weightlifting.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-BAR-001',
                'brand' => 'Rogue',
                'model' => 'Ohio Power Bar',
                'status' => 'available',
                'purchased_at' => '2024-02-25',
                'purchase_price' => 2190000.00, // $300 x 7,300
            ],
            [
                'name' => 'Set de Discos Bumper',
                'description' => 'Set de discos bumper de goma de alta densidad: 2x45lb, 2x35lb, 2x25lb, 4x10lb, totalizando 320lb. Diseño de bajo rebote, centro de acero cromado.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-BUMP-SET1',
                'brand' => 'Rogue',
                'model' => 'Echo Bumper Set',
                'status' => 'available',
                'purchased_at' => '2024-03-01',
                'purchase_price' => 7300000.00, // $1,000 x 7,300
            ],
            [
                'name' => 'Set de Kettlebells',
                'description' => 'Set profesional de kettlebells de hierro fundido con recubrimiento powder coat: 8kg, 12kg, 16kg, 20kg, 24kg, 28kg, 32kg. Mango texturizado para agarre seguro.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-KETL-SET1',
                'brand' => 'Rogue',
                'model' => 'Powder Coat Kettlebell Set',
                'status' => 'available',
                'purchased_at' => '2024-03-10',
                'purchase_price' => 5840000.00, // $800 x 7,300
            ],
            [
                'name' => 'Barra EZ Curl',
                'description' => 'Barra Z cromada para curl de bíceps, 120cm longitud, peso 10kg, diseño ergonómico que reduce tensión en muñecas y codos. Manga olímpica de 50mm.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'REP-EZ-001',
                'brand' => 'REP Fitness',
                'model' => 'EZ Curl Bar',
                'status' => 'available',
                'purchased_at' => '2024-03-15',
                'purchase_price' => 730000.00, // $100 x 7,300
            ],

            // EQUIPOS FUNCIONALES (4 equipos)
            [
                'name' => 'TRX Suspension Trainer',
                'description' => 'Sistema de entrenamiento en suspensión TRX profesional, correas ajustables, anclajes múltiples (puerta, rack, techo), capacidad 180kg. Incluye guía de ejercicios.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'TRX-SUSP-001',
                'brand' => 'TRX',
                'model' => 'Pro4',
                'status' => 'available',
                'purchased_at' => '2024-07-10',
                'purchase_price' => 1460000.00, // $200 x 7,300
            ],
            [
                'name' => 'Battle Ropes',
                'description' => 'Cuerdas de batalla profesionales 15m longitud, 38mm diámetro, material polydac resistente a la intemperie. Ideales para cardio HIIT y acondicionamiento.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-ROPE-001',
                'brand' => 'Rogue',
                'model' => 'Conditioning Rope 1.5"',
                'status' => 'available',
                'purchased_at' => '2024-07-15',
                'purchase_price' => 1095000.00, // $150 x 7,300
            ],
            [
                'name' => 'Cajón Pliométrico 3-en-1',
                'description' => 'Plyo box de madera contrachapada de 20mm, tres alturas en uno: 20"/24"/30" (51/61/76cm). Superficie antideslizante, esquinas redondeadas, capacidad 180kg.',
                'type' => 'strength',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-PLYO-001',
                'brand' => 'Rogue',
                'model' => 'Wood Plyo Box 3-in-1',
                'status' => 'available',
                'purchased_at' => '2024-07-20',
                'purchase_price' => 949000.00, // $130 x 7,300
            ],
            [
                'name' => 'Sled de Arrastre',
                'description' => 'Trineo de potencia con postes verticales para empuje, capacidad de carga 200kg. Base de acero con patines reemplazables. Incluye arnés de arrastre.',
                'type' => 'cardio',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'ROGUE-SLED-001',
                'brand' => 'Rogue',
                'model' => 'Echo Dog Sled',
                'status' => 'available',
                'purchased_at' => '2024-07-25',
                'purchase_price' => 1825000.00, // $250 x 7,300
            ],

            // EQUIPOS DE FLEXIBILIDAD Y MOVILIDAD (3 equipos)
            [
                'name' => 'Foam Roller Texturizado',
                'description' => 'Rodillo de espuma de alta densidad con superficie texturizada 3D, 33cm longitud. Ideal para liberación miofascial, recuperación muscular y masaje profundo.',
                'type' => 'mobility',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'TRIG-FOAM-001',
                'brand' => 'TriggerPoint',
                'model' => 'GRID Foam Roller',
                'status' => 'available',
                'purchased_at' => '2024-08-01',
                'purchase_price' => 219000.00, // $30 x 7,300
            ],
            [
                'name' => 'Colchoneta de Yoga Premium',
                'description' => 'Colchoneta de yoga profesional 6mm grosor, material PVC ecológico, superficie antideslizante en ambos lados, 183cm longitud. Incluye correa de transporte.',
                'type' => 'flexibility',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'MNDK-MAT-001',
                'brand' => 'Manduka',
                'model' => 'PRO Yoga Mat',
                'status' => 'available',
                'purchased_at' => '2024-08-05',
                'purchase_price' => 876000.00, // $120 x 7,300
            ],
            [
                'name' => 'Set de Bandas de Resistencia',
                'description' => 'Set completo de 5 bandas elásticas en loop con diferentes resistencias (X-Light a X-Heavy), 41" circunferencia. Material látex natural de alta calidad.',
                'type' => 'flexibility',
                'image_url' => null,
                'video_url' => null,
                'serial_number' => 'THERA-BAND-SET1',
                'brand' => 'TheraBand',
                'model' => 'CLX Resistance Band Set',
                'status' => 'available',
                'purchased_at' => '2024-08-10',
                'purchase_price' => 219000.00, // $30 x 7,300
            ],
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
            $this->command->info('Seeded: ' . $equipment['name']);
        }

        $this->command->info('Equipment seeded successfully!');
    }
}

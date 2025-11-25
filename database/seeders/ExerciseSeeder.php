<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Este seeder incluye 70 ejercicios esenciales distribuidos en:
     * - Chest (Pecho): 10 ejercicios
     * - Back (Espalda): 10 ejercicios
     * - Legs (Piernas): 15 ejercicios
     * - Arms (Brazos): 12 ejercicios
     * - Shoulders (Hombros): 8 ejercicios
     * - Core (Abdominales): 10 ejercicios
     * - Full Body (Cuerpo Completo): 5 ejercicios
     */
    public function run(): void
    {
        $exercises = [
            // ==================== CHEST EXERCISES (10) ====================
            [
                'equipment_id' => 17, // Banco Plano Olímpico
                'name' => 'Press de Banca Plano',
                'description' => 'Ejercicio fundamental para el desarrollo del pecho. Acostado en un banco plano, baja la barra hasta el pecho y empuja hacia arriba hasta extensión completa de los brazos. Trabaja principalmente pectoral mayor, deltoides anterior y tríceps.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 18, // Banco Ajustable FID
                'name' => 'Press de Banca Inclinado',
                'description' => 'Variación del press de banca en banco inclinado (30-45 grados) que enfatiza la porción superior del pecho. Excelente para desarrollar la parte clavicular del pectoral mayor.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 18, // Banco Ajustable FID
                'name' => 'Press de Banca Declinado',
                'description' => 'Press de banca en banco declinado que enfatiza la porción inferior del pecho. Permite mayor activación de la parte esternal del pectoral mayor.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Aperturas con Mancuernas (Flyes)',
                'description' => 'Ejercicio de aislamiento para el pecho. Con mancuernas en cada mano, abre los brazos en arco amplio manteniendo codos ligeramente flexionados. Excelente para el estiramiento y activación del pectoral.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Flexiones de Pecho (Push-ups)',
                'description' => 'Ejercicio clásico de peso corporal. En posición de plancha, baja el pecho hacia el suelo doblando los codos y empuja de vuelta. Trabaja pecho, hombros, tríceps y core.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 14, // Polea Cruzada Doble
                'name' => 'Cruces en Polea (Cable Crossover)',
                'description' => 'Ejercicio con poleas cruzadas que permite tensión constante en el pectoral. De pie entre dos poleas altas, junta los brazos hacia el centro del cuerpo en movimiento de abrazo.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 8, // Prensa de Pecho máquina
                'name' => 'Press de Pecho en Máquina',
                'description' => 'Ejercicio en máquina selectorizada que proporciona un movimiento guiado y seguro. Ideal para principiantes o para trabajar con peso más controlado al final de la rutina.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Barras paralelas o estación de fondos
                'name' => 'Fondos en Paralelas para Pecho',
                'description' => 'En barras paralelas, inclínate ligeramente hacia adelante y baja el cuerpo flexionando los codos. Excelente para la parte inferior del pecho y tríceps.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Press de Pecho con Mancuernas',
                'description' => 'Similar al press de banca pero con mancuernas, permite mayor rango de movimiento y trabajo unilateral. Acostado en banco, empuja las mancuernas hacia arriba hasta juntar los brazos.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Pullover con Mancuerna',
                'description' => 'Acostado transversalmente en un banco, sostén una mancuerna con ambas manos sobre el pecho y bájala en arco detrás de la cabeza. Trabaja pecho, dorsales y serrato.',
                'muscle_group' => 'Chest',
                'image_url' => null,
                'video_url' => null,
            ],

            // ==================== BACK EXERCISES (10) ====================
            [
                'equipment_id' => 20, // Barra Olímpica
                'name' => 'Peso Muerto (Deadlift)',
                'description' => 'El rey de los ejercicios de espalda y posterior. Con pies a ancho de caderas, agarra la barra y levántala manteniendo la espalda recta. Trabaja toda la cadena posterior: espalda baja, glúteos, isquiotibiales.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Barra de dominadas
                'name' => 'Dominadas (Pull-ups)',
                'description' => 'Colgado de una barra con agarre prono (palmas hacia adelante), jala tu cuerpo hacia arriba hasta que la barbilla pase la barra. Excelente para dorsales, bíceps y fuerza funcional.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Barra de dominadas
                'name' => 'Dominadas con Agarre Supino (Chin-ups)',
                'description' => 'Similar a las dominadas pero con agarre supino (palmas hacia ti). Mayor énfasis en bíceps y porción inferior de los dorsales.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 9, // Jalón al Pecho
                'name' => 'Jalón al Pecho (Lat Pulldown)',
                'description' => 'Sentado en máquina de poleas, jala la barra hacia el pecho. Excelente alternativa a las dominadas y permite ajustar el peso. Trabaja dorsales, trapecios y bíceps.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica
                'name' => 'Remo con Barra (Barbell Row)',
                'description' => 'Inclinado hacia adelante con la espalda recta, jala la barra hacia el abdomen. Fundamental para el grosor de la espalda. Trabaja dorsales, trapecios, romboides y erectores espinales.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Remo con Mancuerna a Una Mano',
                'description' => 'Apoyado en un banco con una rodilla y mano, rema una mancuerna hacia la cadera. Excelente para trabajo unilateral y corrección de desbalances.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // T-Bar Row machine o landmine
                'name' => 'Remo en T (T-Bar Row)',
                'description' => 'Con barra en posición de landmine o máquina T-Bar, jala el peso hacia el pecho en posición inclinada. Excelente para el grosor de la espalda media.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 14, // Polea (Cable row machine)
                'name' => 'Remo Sentado en Polea',
                'description' => 'Sentado frente a una polea baja, jala el agarre hacia el abdomen manteniendo la espalda recta. Tensión constante en dorsales y romboides.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Face Pulls (Jalones Faciales)',
                'description' => 'Con polea alta y cuerda, jala hacia la cara separando las manos. Excelente para deltoides posteriores, trapecios medios y salud del hombro.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica
                'name' => 'Peso Muerto Rumano (Romanian Deadlift)',
                'description' => 'Variación del peso muerto con piernas más rectas, enfocado en isquiotibiales y glúteos. Baja la barra manteniendo las piernas casi extendidas hasta sentir estiramiento en femorales.',
                'muscle_group' => 'Back',
                'image_url' => null,
                'video_url' => null,
            ],

            // ==================== LEGS EXERCISES (15) ====================
            [
                'equipment_id' => 20, // Barra Olímpica + Rack
                'name' => 'Sentadilla con Barra (Back Squat)',
                'description' => 'El rey de los ejercicios de piernas. Con la barra sobre los trapecios, baja hasta que los muslos estén paralelos al suelo o más abajo. Trabaja cuádriceps, glúteos, femorales y core.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica + Rack
                'name' => 'Sentadilla Frontal (Front Squat)',
                'description' => 'Sentadilla con la barra al frente sobre los hombros. Mayor énfasis en cuádriceps y requiere mejor movilidad. Excelente para mantener torso erguido.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 10, // Prensa de Piernas
                'name' => 'Prensa de Piernas (Leg Press)',
                'description' => 'En máquina de prensa, empuja la plataforma con los pies. Permite usar mucho peso de forma segura. Trabaja cuádriceps, glúteos y femorales.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 11, // Extensión de Cuádriceps
                'name' => 'Extensión de Cuádriceps (Leg Extension)',
                'description' => 'Sentado en máquina, extiende las piernas contra la resistencia. Ejercicio de aislamiento para los cuádriceps, ideal para pre-fatiga o post-fatiga.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 12, // Curl de Femoral Acostado
                'name' => 'Curl de Femoral Acostado (Lying Leg Curl)',
                'description' => 'Acostado boca abajo, flexiona las piernas llevando los talones hacia los glúteos. Ejercicio de aislamiento para isquiotibiales.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 12, // Máquina de femoral (puede ser la misma)
                'name' => 'Curl de Femoral Sentado (Seated Leg Curl)',
                'description' => 'Sentado en máquina, flexiona las piernas bajando el rodillo hacia atrás. Variación que permite mayor estiramiento de los isquiotibiales.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica
                'name' => 'Zancadas con Barra (Barbell Lunges)',
                'description' => 'Con barra sobre los hombros, da un paso largo hacia adelante y baja hasta que ambas rodillas estén a 90 grados. Excelente para cuádriceps, glúteos y balance.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Zancadas con Mancuernas',
                'description' => 'Zancadas sosteniendo mancuernas a los lados. Permite mejor balance que la versión con barra y trabajo unilateral efectivo.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Sentadilla Búlgara (Bulgarian Split Squat)',
                'description' => 'Con un pie elevado en un banco detrás de ti, baja en sentadilla con la pierna delantera. Excelente para cuádriceps, glúteos y corrección de desbalances.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Máquina de pantorrillas o soporte
                'name' => 'Elevación de Pantorrillas de Pie (Standing Calf Raise)',
                'description' => 'De pie sobre un escalón, eleva los talones lo más alto posible y baja lentamente. Trabaja gastrocnemios (gemelos).',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Máquina de pantorrillas sentado
                'name' => 'Elevación de Pantorrillas Sentado (Seated Calf Raise)',
                'description' => 'Sentado con peso sobre las rodillas, eleva los talones. Mayor énfasis en el sóleo (pantorrilla profunda).',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica o banco con barra
                'name' => 'Hip Thrust (Empuje de Cadera)',
                'description' => 'Con espalda apoyada en banco y barra sobre la cadera, empuja la cadera hacia arriba. El mejor ejercicio para glúteos y desarrollo de la cadena posterior.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Máquina específica o Smith Machine
                'name' => 'Hack Squat',
                'description' => 'En máquina hack squat, empuja la plataforma con los pies. Excelente para cuádriceps con menos estrés en la espalda baja que la sentadilla tradicional.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Sentadilla Goblet',
                'description' => 'Sosteniendo una mancuerna vertical contra el pecho, realiza una sentadilla profunda. Excelente para aprender la técnica de sentadilla y movilidad.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Step-up box o banco
                'name' => 'Step-ups (Subidas al Cajón)',
                'description' => 'Sube a un cajón o banco con una pierna y baja controladamente. Excelente para cuádriceps, glúteos y fuerza unilateral.',
                'muscle_group' => 'Legs',
                'image_url' => null,
                'video_url' => null,
            ],

            // ==================== ARMS EXERCISES (12) ====================
            [
                'equipment_id' => 20, // Barra Olímpica o EZ Bar
                'name' => 'Curl de Bíceps con Barra',
                'description' => 'De pie con barra en las manos, flexiona los codos llevando la barra hacia los hombros. El ejercicio fundamental para el desarrollo de bíceps.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 23, // Barra EZ Curl
                'name' => 'Curl de Bíceps con Barra Z (EZ Bar Curl)',
                'description' => 'Curl de bíceps con barra Z que reduce la tensión en las muñecas. Permite un agarre más natural y cómodo.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Curl de Bíceps con Mancuernas',
                'description' => 'Con mancuernas a los lados, flexiona los codos alternando brazos o simultáneamente. Permite supinación completa y trabajo unilateral.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Curl Martillo (Hammer Curl)',
                'description' => 'Curl de bíceps con palmas enfrentadas (agarre neutro). Trabaja bíceps, braquial y braquiorradial. Excelente para el grosor del brazo.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Banco Scott + mancuerna/barra
                'name' => 'Curl Predicador (Preacher Curl)',
                'description' => 'Sentado en banco Scott, brazo apoyado, realiza curl aislado. Elimina el impulso y enfoca totalmente el trabajo en el bíceps.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Curl de Concentración',
                'description' => 'Sentado con codo apoyado en el muslo interno, realiza curl lento y controlado. Excelente aislamiento del bíceps.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 14, // Polea alta
                'name' => 'Extensión de Tríceps en Polea (Tricep Pushdown)',
                'description' => 'Frente a polea alta, empuja la barra o cuerda hacia abajo extendiendo los codos. Ejercicio fundamental para tríceps, especialmente la cabeza lateral.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas o barra
                'name' => 'Extensión de Tríceps Acostado (Skull Crushers)',
                'description' => 'Acostado en banco con barra sobre la frente, baja flexionando solo los codos y extiende. Excelente para la cabeza larga del tríceps.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Mancuerna
                'name' => 'Extensión de Tríceps Sobre la Cabeza (Overhead Extension)',
                'description' => 'De pie o sentado, sostén una mancuerna con ambas manos sobre la cabeza y baja detrás de la cabeza flexionando los codos. Enfoca la cabeza larga del tríceps.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Barras paralelas
                'name' => 'Fondos para Tríceps (Tricep Dips)',
                'description' => 'En barras paralelas, mantén el cuerpo erguido y baja flexionando los codos. Excelente ejercicio compuesto para tríceps.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 17, // Banco plano
                'name' => 'Press de Banca con Agarre Cerrado',
                'description' => 'Press de banca con las manos más juntas (ancho de hombros). Mayor énfasis en tríceps mientras también trabaja pecho.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Curl de Muñeca (Wrist Curl)',
                'description' => 'Sentado con antebrazos sobre las piernas, flexiona las muñecas hacia arriba con mancuernas. Desarrolla los flexores del antebrazo.',
                'muscle_group' => 'Arms',
                'image_url' => null,
                'video_url' => null,
            ],

            // ==================== SHOULDERS EXERCISES (8) ====================
            [
                'equipment_id' => 20, // Barra Olímpica
                'name' => 'Press Militar con Barra (Overhead Press)',
                'description' => 'De pie con barra a nivel de hombros, empuja hacia arriba hasta extensión completa. El mejor ejercicio para el desarrollo completo de hombros.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Press de Hombros con Mancuernas',
                'description' => 'Sentado o de pie, empuja mancuernas desde los hombros hacia arriba. Permite mayor rango de movimiento y trabajo unilateral.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 15, // Press de Hombros Sentado máquina
                'name' => 'Press de Hombros en Máquina',
                'description' => 'En máquina selectorizada, empuja hacia arriba. Movimiento guiado que permite enfocarse en el esfuerzo sin preocuparse por el balance.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Elevaciones Laterales (Lateral Raises)',
                'description' => 'De pie con mancuernas a los lados, eleva los brazos lateralmente hasta la altura de los hombros. Aísla el deltoides lateral (medio).',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas
                'name' => 'Elevaciones Frontales (Front Raises)',
                'description' => 'De pie, eleva las mancuernas al frente hasta la altura de los hombros. Trabaja principalmente el deltoides anterior.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas o máquina pec deck invertida
                'name' => 'Elevaciones Posteriores (Reverse Flyes)',
                'description' => 'Inclinado hacia adelante, eleva las mancuernas lateralmente. Fundamental para el deltoides posterior y salud del hombro.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica o EZ Bar
                'name' => 'Remo Vertical (Upright Row)',
                'description' => 'Con barra frente al cuerpo, jala hacia arriba manteniendo codos más altos que las manos. Trabaja deltoides y trapecios superiores.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Set de Mancuernas o barra
                'name' => 'Encogimientos de Hombros (Shrugs)',
                'description' => 'Con peso en las manos, eleva los hombros hacia las orejas. El mejor ejercicio para el desarrollo de trapecios.',
                'muscle_group' => 'Shoulders',
                'image_url' => null,
                'video_url' => null,
            ],

            // ==================== CORE EXERCISES (10) ====================
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Plancha (Plank)',
                'description' => 'En posición de antebrazo o manos extendidas, mantén el cuerpo recto como una tabla. El mejor ejercicio isométrico para core, trabaja todo el abdomen y estabilizadores.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Plancha Lateral (Side Plank)',
                'description' => 'Apoyado en un antebrazo lateral, mantén el cuerpo recto. Excelente para oblicuos y estabilidad lateral del core.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Peso corporal o colchoneta
                'name' => 'Crunches Abdominales',
                'description' => 'Acostado boca arriba con rodillas flexionadas, eleva los hombros del suelo contrayendo el abdomen. Clásico ejercicio para el recto abdominal.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Bicicleta (Bicycle Crunches)',
                'description' => 'Acostado, alterna llevando codo al rodilla opuesta en movimiento de pedaleo. Excelente para oblicuos y recto abdominal.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Mancuerna o disco
                'name' => 'Giros Rusos (Russian Twists)',
                'description' => 'Sentado con torso inclinado hacia atrás, gira de lado a lado sosteniendo un peso. Trabaja intensamente los oblicuos.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Barra de dominadas o banco
                'name' => 'Elevación de Piernas (Leg Raises)',
                'description' => 'Colgado de una barra o acostado, eleva las piernas extendidas. Excelente para el abdomen inferior.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Escaladores (Mountain Climbers)',
                'description' => 'En posición de plancha alta, alterna llevando las rodillas hacia el pecho rápidamente. Combina cardio con trabajo de core.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Ab wheel
                'name' => 'Rueda Abdominal (Ab Wheel Rollout)',
                'description' => 'De rodillas, rueda hacia adelante extendiendo el cuerpo y regresa. Ejercicio extremadamente efectivo para todo el core.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 14, // Polea alta
                'name' => 'Crunches en Polea (Cable Crunches)',
                'description' => 'Arrodillado frente a polea alta con cuerda, contrae el abdomen jalando hacia abajo. Permite agregar resistencia progresiva a los abdominales.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Dead Bug (Bicho Muerto)',
                'description' => 'Acostado boca arriba, alterna extendiendo brazo y pierna opuestos mientras mantienes espalda baja pegada al suelo. Excelente para estabilidad del core.',
                'muscle_group' => 'Core',
                'image_url' => null,
                'video_url' => null,
            ],

            // ==================== FULL BODY EXERCISES (5) ====================
            [
                'equipment_id' => null, // Peso corporal
                'name' => 'Burpees',
                'description' => 'Combinación de sentadilla, plancha, flexión y salto. El ejercicio de cuerpo completo más intenso que existe. Trabaja piernas, pecho, core y mejora la resistencia cardiovascular.',
                'muscle_group' => 'Full Body',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 19, // Mancuernas
                'name' => 'Thrusters (Sentadilla con Press)',
                'description' => 'Sostén mancuernas en los hombros, realiza una sentadilla y al subir empuja las mancuernas sobre la cabeza. Combina piernas y hombros en un movimiento explosivo.',
                'muscle_group' => 'Full Body',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 22, // Set de Kettlebells
                'name' => 'Swings con Kettlebell',
                'description' => 'Con kettlebell entre las piernas, balancea explosivamente hasta la altura de los hombros usando la cadera. Excelente para potencia, glúteos y acondicionamiento.',
                'muscle_group' => 'Full Body',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 20, // Barra Olímpica
                'name' => 'Clean and Press (Cargada y Press)',
                'description' => 'Levanta la barra desde el suelo hasta los hombros (clean) y luego empuja sobre la cabeza (press). Ejercicio olímpico que desarrolla potencia total del cuerpo.',
                'muscle_group' => 'Full Body',
                'image_url' => null,
                'video_url' => null,
            ],
            [
                'equipment_id' => 25, // Battle Ropes
                'name' => 'Battle Ropes (Cuerdas de Batalla)',
                'description' => 'Con una cuerda en cada mano, crea ondas alternas o simultáneas. Ejercicio de alta intensidad que trabaja brazos, hombros, core y mejora la resistencia.',
                'muscle_group' => 'Full Body',
                'image_url' => null,
                'video_url' => null,
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }

        $this->command->info('Exercises seeded successfully.');
    }
}

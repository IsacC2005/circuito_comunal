<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * FakeDataSeeder
 *
 * Pobla la base de datos con datos masivos de prueba:
 *   - 20 circuitos
 *   - 22 comunidades por circuito  (440 en total)
 *   - 10 calles por comunidad      (4 400 en total)
 *   - 10 casas por calle           (44 000 en total)
 *   - 2 familias por casa          (88 000 en total)
 *   - 5 personas por familia       (440 000 en total)
 *   - ~20 % de personas con discapacidad
 *   - ~60 % de familias con bombonas asignadas
 *   - ~50 % de familias con módulos de alimentos asignados
 */
class FakeDataSeeder extends Seeder
{
    private int $cedulaCounter = 10_000_001;

    private array $disabilityIds  = [];
    private array $gasCylinderIds = [];
    private array $foodModuleIds  = [];

    private \Faker\Generator $faker;

    // Catálogos de enums para no rellenar arrays en cada iteración
    private array $houseStatuses  = ['propia', 'prestada', 'alquilada', 'hospedado', 'otra'];
    private array $relationships  = ['conyuge', 'hijo(a)', 'nieto(a)', 'otro'];
    private array $nationalities  = ['venezolano', 'venezolano', 'venezolano', 'extranjero'];
    private array $academicLevels = ['ninguno', 'primaria', 'primaria', 'secundaria', 'secundaria', 'universitaria', 'postgrado'];
    private array $streetPrefixes = ['Calle', 'Avenida', 'Carrera', 'Vereda', 'Callejón', 'Pasaje', 'Urbanización'];

    // -------------------------------------------------------------------------

    public function run(): void
    {
        $this->faker = FakerFactory::create('es_VE');

        // Llama primero a los seeders de datos de referencia
        $this->call([
            DisabilitySeeder::class,
            GasCylinderSeeder::class,
            FoodModuleSeeder::class,
        ]);

        // Carga los IDs de referencia
        $this->disabilityIds  = DB::table('disabilities')->pluck('id')->toArray();
        $this->gasCylinderIds = DB::table('gas_cylinders')->pluck('id')->toArray();
        $this->foodModuleIds  = DB::table('food_modules')->pluck('id')->toArray();

        $this->command->info('Iniciando carga masiva de datos…');
        $this->command->getOutput()->progressStart(20);

        for ($c = 1; $c <= 20; $c++) {
            $circuitId = DB::table('circuits')->insertGetId([
                'name'       => "Circuito Comunal #{$c} — " . $this->faker->city(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($co = 1; $co <= 22; $co++) {
                $communityId = DB::table('communities')->insertGetId([
                    'circuit_id'       => $circuitId,
                    'name'             => "Comunidad {$co} — " . $this->faker->unique()->city(),
                    'code_citur'       => strtoupper(Str::random(4)) . '-' . $this->faker->numerify('####'),
                    'invitation_token' => Str::uuid()->toString(),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                $this->seedCommunity($communityId);
            }

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('¡Carga masiva completada!');
    }

    // -------------------------------------------------------------------------

    private function seedCommunity(int $communityId): void
    {
        $now = now()->toDateTimeString();

        // ── 1. CALLES (10 por comunidad) ────────────────────────────────────
        $streetsData = [];
        for ($i = 1; $i <= 10; $i++) {
            $streetsData[] = [
                'community_id' => $communityId,
                'leader_id'    => null,
                'name'         => $this->faker->randomElement($this->streetPrefixes) . ' ' . $i
                    . ' — ' . $this->faker->streetName(),
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        DB::table('streets')->insert($streetsData);

        $streetIds = DB::table('streets')
            ->where('community_id', $communityId)
            ->pluck('id')
            ->toArray();

        // ── 2. CASAS (10 por calle = 100 por comunidad) ─────────────────────
        $housesData = [];
        foreach ($streetIds as $streetId) {
            for ($h = 1; $h <= 10; $h++) {
                $housesData[] = [
                    'community_id' => $communityId,
                    'street_id'    => $streetId,
                    'number'       => (string) $h,
                    'description'  => null,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }
        DB::table('houses')->insert($housesData);

        $houseIds = DB::table('houses')
            ->where('community_id', $communityId)
            ->pluck('id')
            ->toArray();

        // ── 3. FAMILIAS (2 por casa = 200 por comunidad) ────────────────────
        $familiesData = [];
        foreach ($houseIds as $houseId) {
            for ($f = 0; $f < 2; $f++) {
                $familiesData[] = [
                    'community_id' => $communityId,
                    'house_id'     => $houseId,
                    'house_status' => $this->faker->randomElement($this->houseStatuses),
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }
        DB::table('families')->insert($familiesData);

        $familyIds = DB::table('families')
            ->where('community_id', $communityId)
            ->pluck('id')
            ->toArray();

        // ── 4. PERSONAS (5 por familia = 1 000 por comunidad) ───────────────
        $peopleData = [];
        foreach ($familyIds as $familyId) {
            // Primer miembro siempre es "jefe de familia"
            $peopleData[] = $this->buildPerson($communityId, $familyId, 'jefe de familia', $now);

            // Resto de miembros (4)
            for ($p = 1; $p < 5; $p++) {
                $peopleData[] = $this->buildPerson(
                    $communityId,
                    $familyId,
                    $this->faker->randomElement($this->relationships),
                    $now,
                );
            }
        }

        // Inserción en bloques de 1 000 para evitar límites de parámetros SQL
        foreach (array_chunk($peopleData, 1000) as $chunk) {
            DB::table('people')->insert($chunk);
        }

        // ── 5. ASIGNAR LÍDER A CADA CALLE ───────────────────────────────────
        $personIds = DB::table('people')
            ->where('community_id', $communityId)
            ->pluck('id')
            ->toArray();

        shuffle($personIds);
        foreach ($streetIds as $index => $streetId) {
            DB::table('streets')
                ->where('id', $streetId)
                ->update(['leader_id' => $personIds[$index % count($personIds)]]);
        }

        // ── 6. DISCAPACIDADES (~20 % de las personas) ───────────────────────
        if (!empty($this->disabilityIds)) {
            $disabledPersonIds = $this->randomSubset($personIds, (int)(count($personIds) * 0.20));
            $disabilityPivot   = [];

            foreach ($disabledPersonIds as $personId) {
                $qty      = rand(1, 2);
                $selected = $this->randomSubset($this->disabilityIds, $qty);

                foreach ($selected as $disabilityId) {
                    $disabilityPivot[] = [
                        'person_id'     => $personId,
                        'disability_id' => $disabilityId,
                    ];
                }
            }

            foreach (array_chunk($disabilityPivot, 500) as $chunk) {
                DB::table('disable_person')->insert($chunk);
            }
        }

        // ── 7. BOMBONAS DE GAS (~60 % de las familias) ──────────────────────
        if (!empty($this->gasCylinderIds)) {
            $gasData = [];
            foreach ($familyIds as $familyId) {
                if (rand(1, 100) <= 60) {
                    $gasData[] = [
                        'family_id'      => $familyId,
                        'gas_cylinder_id' => $this->faker->randomElement($this->gasCylinderIds),
                        'count'          => rand(1, 3),
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];
                }
            }
            foreach (array_chunk($gasData, 500) as $chunk) {
                DB::table('family_gas_cylinder')->insert($chunk);
            }
        }

        // ── 8. MÓDULOS DE ALIMENTOS (~50 % de las familias) ─────────────────
        if (!empty($this->foodModuleIds)) {
            $foodData = [];
            foreach ($familyIds as $familyId) {
                if (rand(1, 100) <= 50) {
                    $foodData[] = [
                        'family_id'      => $familyId,
                        'food_module_id' => $this->faker->randomElement($this->foodModuleIds),
                        'count'          => rand(1, 2),
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];
                }
            }
            foreach (array_chunk($foodData, 500) as $chunk) {
                DB::table('family_food_module')->insert($chunk);
            }
        }
    }

    // -------------------------------------------------------------------------

    private function buildPerson(
        int    $communityId,
        int    $familyId,
        string $relationship,
        string $now,
    ): array {
        $gender = $this->faker->randomElement(['masculino', 'masculino', 'femenino', 'femenino', 'otro']);

        return [
            'community_id'   => $communityId,
            'family_id'      => $familyId,
            'first_name'     => $gender === 'femenino'
                ? $this->faker->firstNameFemale()
                : $this->faker->firstNameMale(),
            'second_name'    => rand(0, 1) ? $this->faker->firstName() : null,
            'first_surname'  => $this->faker->lastName(),
            'second_surname' => rand(0, 2) ? $this->faker->lastName() : null,
            'cedula'         => $this->cedulaCounter++,
            'gender'         => $gender,
            'birth_date'     => $this->faker->dateTimeBetween('-80 years', '-5 years')->format('Y-m-d'),
            'relationship'   => $relationship,
            'nationality'    => $this->faker->randomElement($this->nationalities),
            'academic_level' => $this->faker->randomElement($this->academicLevels),
            'created_at'     => $now,
            'updated_at'     => $now,
        ];
    }

    /**
     * Retorna un subconjunto aleatorio de $n elementos del array dado.
     */
    private function randomSubset(array $array, int $n): array
    {
        if ($n <= 0 || empty($array)) {
            return [];
        }

        $n = min($n, count($array));
        $keys = array_rand($array, $n);

        return array_map(fn($k) => $array[$k], (array) $keys);
    }
}

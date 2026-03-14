<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        $gender = fake()->randomElement(['masculino', 'femenino', 'otro']);

        return [
            'community_id'   => Community::factory(),
            'family_id'      => Family::factory(),
            'first_name'     => $gender === 'femenino'
                ? fake()->firstNameFemale()
                : fake()->firstNameMale(),
            'second_name'    => fake()->optional(0.5)->firstName(),
            'first_surname'  => fake()->lastName(),
            'second_surname' => fake()->optional(0.7)->lastName(),
            'cedula'         => fake()->unique()->numerify('########'),
            'gender'         => $gender,
            'birth_date'     => fake()->dateTimeBetween('-80 years', '-5 years')->format('Y-m-d'),
            'relationship'   => 'jefe de familia',
            'nationality'    => fake()->randomElement(['venezolano', 'extranjero']),
            'academic_level' => fake()->randomElement(['ninguno', 'primaria', 'secundaria', 'universitaria', 'postgrado']),
        ];
    }

    public function male(): static
    {
        return $this->state(fn() => [
            'gender'     => 'masculino',
            'first_name' => fake()->firstNameMale(),
        ]);
    }

    public function female(): static
    {
        return $this->state(fn() => [
            'gender'     => 'femenino',
            'first_name' => fake()->firstNameFemale(),
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreetFactory extends Factory
{
    private static array $prefixes = ['Calle', 'Avenida', 'Carrera', 'Vereda', 'Callejón', 'Pasaje', 'Urbanización'];

    public function definition(): array
    {
        return [
            'community_id' => Community::factory(),
            'leader_id'    => null,
            'name'         => fake()->randomElement(self::$prefixes) . ' ' . fake()->streetName(),
        ];
    }
}

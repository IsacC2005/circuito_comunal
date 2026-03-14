<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'community_id' => Community::factory(),
            'house_id'     => House::factory(),
            'house_status' => fake()->randomElement(['propia', 'prestada', 'alquilada', 'hospedado', 'otra']),
        ];
    }
}

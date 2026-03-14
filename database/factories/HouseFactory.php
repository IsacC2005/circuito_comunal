<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'community_id' => Community::factory(),
            'street_id'    => Street::factory(),
            'number'       => (string) fake()->numberBetween(1, 200),
            'description'  => fake()->optional(0.3)->sentence(),
        ];
    }
}

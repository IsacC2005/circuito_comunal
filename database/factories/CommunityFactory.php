<?php

namespace Database\Factories;

use App\Models\Circuit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommunityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'circuit_id'       => Circuit::factory(),
            'name'             => 'Comunidad ' . fake()->unique()->numerify('##') . ' - ' . fake()->streetName(),
            'code_citur'       => strtoupper(Str::random(4)) . '-' . fake()->numerify('####'),
            'invitation_token' => Str::uuid()->toString(),
        ];
    }
}

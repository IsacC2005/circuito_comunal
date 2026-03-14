<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CircuitFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 1;

        return [
            'name' => 'Circuito Comunal ' . $counter++,
        ];
    }
}

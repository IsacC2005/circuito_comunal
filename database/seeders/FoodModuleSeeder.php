<?php

namespace Database\Seeders;

use App\Models\FoodModule;
use Illuminate\Database\Seeder;

class FoodModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'CLAP Básico',
            'Proteína Animal',
            'Módulo de Salud / Nutricional',
            'Combo Regional / Estadal',
            'CNAE / Escolar',
            'Feria del Campo Soberano',
        ];

        foreach ($modules as $name) {
            FoodModule::firstOrCreate(['name' => $name]);
        }
    }
}

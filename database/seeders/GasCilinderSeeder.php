<?php

namespace Database\Seeders;

use App\Models\GasCilinder;
use App\Models\GasCilinderCompany;
use App\Models\GasCilinderTypeConnection;
use Illuminate\Database\Seeder;

class GasCilinderSeeder extends Seeder
{
    public function run(): void
    {
        // Empresas
        $companies = ['Comunal', 'Tomagas', 'Radelco'];
        foreach ($companies as $name) {
            GasCilinderCompany::firstOrCreate(['name' => $name]);
        }

        // Tipos de conexión
        $typeConnections = ['Clip-On', 'Rosca POL', 'Punta fina'];
        foreach ($typeConnections as $name) {
            GasCilinderTypeConnection::firstOrCreate(['name' => $name]);
        }

        // Combinaciones válidas de tamaño y tipo de conexión:
        // Clip-On  -> 10kg
        // Punta fina -> 10kg
        // Rosca POL  -> 18kg, 43kg
        $combinations = [
            ['size' => 10, 'type' => 'Clip-On'],
            ['size' => 10, 'type' => 'Punta fina'],
            ['size' => 18, 'type' => 'Rosca POL'],
            ['size' => 43, 'type' => 'Rosca POL'],
        ];

        foreach (GasCilinderCompany::all() as $company) {
            foreach ($combinations as $combo) {
                $typeConnection = GasCilinderTypeConnection::where('name', $combo['type'])->first();
                GasCilinder::firstOrCreate([
                    'company_id'         => $company->id,
                    'size'               => $combo['size'],
                    'type_connection_id' => $typeConnection->id,
                ]);
            }
        }
    }
}

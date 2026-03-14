<?php

namespace Database\Seeders;

use App\Models\GasCylinder;
use App\Models\GasCylinderCompany;
use App\Models\GasCylinderTypeConnection;
use Illuminate\Database\Seeder;

class GasCylinderSeeder extends Seeder
{
    public function run(): void
    {
        // Empresas
        $companies = ['Comunal', 'Tomagas', 'Radelco'];
        foreach ($companies as $name) {
            GasCylinderCompany::firstOrCreate(['name' => $name]);
        }

        // Tipos de conexión
        $typeConnections = ['Clip-On', 'Rosca POL', 'Punta fina'];
        foreach ($typeConnections as $name) {
            GasCylinderTypeConnection::firstOrCreate(['name' => $name]);
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

        foreach (GasCylinderCompany::all() as $company) {
            foreach ($combinations as $combo) {
                $typeConnection = GasCylinderTypeConnection::where('name', $combo['type'])->first();
                GasCylinder::firstOrCreate([
                    'company_id'         => $company->id,
                    'size'               => $combo['size'],
                    'type_connection_id' => $typeConnection->id,
                ]);
            }
        }
    }
}

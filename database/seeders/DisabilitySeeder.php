<?php

namespace Database\Seeders;

use App\Models\Disability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisabilitySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $disabilities = [
            // Física
            ['name' => 'Parálisis cerebral',          'type' => 'física'],
            ['name' => 'Amputación de miembro',        'type' => 'física'],
            ['name' => 'Esclerosis múltiple',           'type' => 'física'],
            ['name' => 'Distrofia muscular',            'type' => 'física'],
            ['name' => 'Lesión medular / paraplejia',   'type' => 'física'],
            ['name' => 'Tetraplejia',                   'type' => 'física'],
            ['name' => 'Hemiplejia',                    'type' => 'física'],
            ['name' => 'Artritis reumatoide grave',     'type' => 'física'],
            ['name' => 'Espina bífida',                 'type' => 'física'],
            ['name' => 'Secuela de accidente cerebrovascular (ACV)', 'type' => 'física'],

            // Sensorial
            ['name' => 'Ceguera total',                'type' => 'sensorial'],
            ['name' => 'Baja visión',                  'type' => 'sensorial'],
            ['name' => 'Sordera profunda',             'type' => 'sensorial'],
            ['name' => 'Hipoacusia (pérdida parcial de audición)', 'type' => 'sensorial'],
            ['name' => 'Sordoceguera',                 'type' => 'sensorial'],
            ['name' => 'Trastorno del procesamiento auditivo central', 'type' => 'sensorial'],

            // Intelectual
            ['name' => 'Discapacidad intelectual leve',    'type' => 'intelectual'],
            ['name' => 'Discapacidad intelectual moderada', 'type' => 'intelectual'],
            ['name' => 'Discapacidad intelectual severa',   'type' => 'intelectual'],
            ['name' => 'Síndrome de Down',                  'type' => 'intelectual'],
            ['name' => 'Trastorno del espectro autista (TEA)', 'type' => 'intelectual'],
            ['name' => 'Síndrome de Williams',              'type' => 'intelectual'],
            ['name' => 'Síndrome de Angelman',              'type' => 'intelectual'],
            ['name' => 'Fenilcetonuria',                    'type' => 'intelectual'],

            // Psicosocial
            ['name' => 'Esquizofrenia',                     'type' => 'psicosocial'],
            ['name' => 'Trastorno bipolar',                 'type' => 'psicosocial'],
            ['name' => 'Trastorno depresivo mayor crónico', 'type' => 'psicosocial'],
            ['name' => 'Trastorno de ansiedad generalizada crónico', 'type' => 'psicosocial'],
            ['name' => 'Trastorno límite de la personalidad (TLP)', 'type' => 'psicosocial'],
            ['name' => 'Trastorno obsesivo-compulsivo (TOC)', 'type' => 'psicosocial'],
            ['name' => 'Trastorno de estrés postraumático (TEPT)', 'type' => 'psicosocial'],

            // Otra
            ['name' => 'Epilepsia refractaria',             'type' => 'otra'],
            ['name' => 'Trastorno del lenguaje y comunicación', 'type' => 'otra'],
            ['name' => 'Enfermedad crónica invalidante',    'type' => 'otra'],
            ['name' => 'Trastorno del aprendizaje (dislexia, discalculia)', 'type' => 'otra'],
            ['name' => 'Trastorno por déficit de atención e hiperactividad (TDAH)', 'type' => 'otra'],
        ];

        foreach ($disabilities as $disability) {
            Disability::firstOrCreate(
                ['name' => $disability['name']],
                ['type' => $disability['type']]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Crear usuario super admin por defecto
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );

        $user->assignRole($superAdmin);

        $this->call([
            DisabilitySeeder::class,
            GasCylinderSeeder::class,
            FoodModuleSeeder::class,
        ]);

        // Para poblar con datos masivos de prueba ejecutar:
        // php artisan db:seed --class=FakeDataSeeder
    }
}

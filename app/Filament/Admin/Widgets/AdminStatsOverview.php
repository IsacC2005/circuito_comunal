<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Family;
use App\Models\House;
use App\Models\Person;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalPersons = Person::count();
        $totalHouses  = House::count();
        $totalFamilies = Family::count();

        $density = $totalHouses > 0
            ? round($totalPersons / $totalHouses, 2)
            : 0;

        $foodCount = Family::has('foodModules')->count();

        $gasCount = Family::has('gasCilinders')->count();

        $foodPercent = $totalFamilies > 0
            ? round(($foodCount / $totalFamilies) * 100, 1)
            : 0;

        $gasPercent = $totalFamilies > 0
            ? round(($gasCount / $totalFamilies) * 100, 1)
            : 0;

        return [
            Stat::make('Total de Personas Registradas', number_format($totalPersons))
                ->description('Personas en todo el sistema')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Densidad Familiar', $density . ' pers/casa')
                ->description('Promedio de personas por vivienda')
                ->descriptionIcon('heroicon-o-home')
                ->color($density >= 5 ? 'danger' : 'success'),

            Stat::make('Familias con Módulo de Comida', $foodPercent . '%')
                ->description("{$foodCount} de {$totalFamilies} familias")
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('warning'),

            Stat::make('Familias con Cilindro de Gas', $gasPercent . '%')
                ->description("{$gasCount} de {$totalFamilies} familias")
                ->descriptionIcon('heroicon-o-fire')
                ->color('info'),
        ];
    }
}

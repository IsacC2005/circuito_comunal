<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Circuit;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CircuitDistributionChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Distribución por Circuito';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $circuits = Circuit::withCount('communities')
            ->orderBy('name')
            ->get();

        $labels = $circuits->pluck('name')->toArray();
        $communitiesData = $circuits->pluck('communities_count')->toArray();

        // Persons count per circuit via communities
        $personsByCircuit = DB::table('circuits')
            ->leftJoin('communities', 'circuits.id', '=', 'communities.circuit_id')
            ->leftJoin('people', 'communities.id', '=', 'people.community_id')
            ->groupBy('circuits.id', 'circuits.name')
            ->orderBy('circuits.name')
            ->select('circuits.name', DB::raw('COUNT(people.id) as total'))
            ->pluck('total', 'circuits.name');

        $personsData = array_map(
            fn (string $name) => (int) ($personsByCircuit[$name] ?? 0),
            $labels
        );

        return [
            'datasets' => [
                [
                    'label'           => 'Comunidades',
                    'data'            => $communitiesData,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.7)',
                    'borderColor'     => 'rgba(251, 191, 36, 1)',
                    'borderWidth'     => 1,
                ],
                [
                    'label'           => 'Personas',
                    'data'            => $personsData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.7)',
                    'borderColor'     => 'rgba(59, 130, 246, 1)',
                    'borderWidth'     => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

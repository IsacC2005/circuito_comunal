<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DisabilityChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Censo de Discapacidad Nacional';

    protected function getData(): array
    {
        $results = DB::table('disabilities')
            ->leftJoin('disable_person', 'disabilities.id', '=', 'disable_person.disability_id')
            ->groupBy('disabilities.type')
            ->select('disabilities.type', DB::raw('COUNT(disable_person.disability_id) as total'))
            ->orderByDesc('total')
            ->get();

        $colorMap = [
            'física'       => 'rgba(59, 130, 246, 0.8)',
            'sensorial'    => 'rgba(16, 185, 129, 0.8)',
            'intelectual'  => 'rgba(251, 191, 36, 0.8)',
            'psicosocial'  => 'rgba(239, 68, 68, 0.8)',
            'otra'         => 'rgba(156, 163, 175, 0.8)',
        ];

        $labels = $results->pluck('type')->toArray();
        $data   = $results->pluck('total')->toArray();
        $colors = array_map(fn (string $type) => $colorMap[$type] ?? 'rgba(156, 163, 175, 0.8)', $labels);

        return [
            'datasets' => [
                [
                    'data'            => $data,
                    'backgroundColor' => $colors,
                    'hoverOffset'     => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Click;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ClicksChart extends ChartWidget
{
    protected static ?string $heading = 'Переходы за последние 30 дней';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $startDate = now()->subDays(29)->startOfDay();

        // Получаем количество кликов по дням
        $clicks = Click::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        for ($date = $startDate->copy(); $date->lte(now()); $date->addDay()) {
            $day = $date->format('Y-m-d');

            $labels[] = $date->format('d.m');
            $data[] = $clicks[$day] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Переходы',
                    'data' => $data,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

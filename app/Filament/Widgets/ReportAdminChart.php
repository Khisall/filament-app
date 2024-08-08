<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use App\Models\HoseReel;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ReportAdminChart extends ChartWidget
{
    protected static ?string $heading = 'Reports Chart';

    protected static ?int $sort = 3;

    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::model(HoseReel::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Reports',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

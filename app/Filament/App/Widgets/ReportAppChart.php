<?php

namespace App\Filament\App\Widgets;

use App\Models\Report;
use App\Models\HoseReel;
use Flowframe\Trend\Trend;
use Filament\Facades\Filament;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ReportAppChart extends ChartWidget
{
    protected static ?string $heading = 'Reports Chart';

    protected static ?int $sort = 3;

    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::query(HoseReel::query()->whereBelongsTo(Filament::getTenant()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
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
        return 'line';
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Report;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class WarningChart extends ChartWidget
{
    protected static ?string $heading = 'Warning Chart';

    protected static ?int $sort = 2;

    protected static string $color = 'warning';

    protected function getData(): array
    {
        
        $data = Trend::query(Report::where('remark', 'No Good'))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'No Good',
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

<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Report;
use App\Models\HoseReel;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class WarningChart extends ChartWidget
{
    protected static ?string $heading = 'No Good $ Good Hose Reel Condition';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        
        $nogood = Trend::query(HoseReel::where('condition', 'NO GOOD'))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $goodData = Trend::query(
            HoseReel::where('condition', 'GOOD')
            )
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

            return [
                'datasets' => [
                    [
                        'label' => 'NO GOOD',
                        'data' => $nogood->map(fn (TrendValue $value) => $value->aggregate),
                        'backgroundColor' => 'rgba(255, 159, 64, 0.2)', // Orange color for NO GOOD
                        'borderColor' => 'rgba(255, 159, 64, 1)', // Orange border color for NO GOOD
                        'borderWidth' => 2,
                    ],
                    [
                        'label' => 'GOOD',
                        'data' => $goodData->map(fn (TrendValue $value) => $value->aggregate),
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Green color for GOOD
                        'borderColor' => 'rgba(75, 192, 192, 1)', // Green border color for GOOD
                        'borderWidth' => 2,
                    ],
                ],
                'labels' => $nogood->map(fn (TrendValue $value) => $value->date), // Assuming both datasets have the same dates
            ];
        }

    protected function getType(): string
    {
        return 'line';
    }
}

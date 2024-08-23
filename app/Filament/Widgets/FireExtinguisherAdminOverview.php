<?php

namespace App\Filament\Widgets;

use App\Models\Team;
use App\Models\User;
use App\Models\Report;
use App\Models\HoseReel;
use App\Models\FireExtinguisher;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class FireExtinguisherAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $goodCount = FireExtinguisher::where('tube_condition', 'GOOD')->count();
        $warningCount = FireExtinguisher::where('tube_condition', 'NO GOOD')->count();

        return [
            Card::make('Fire Extinguisher Remarks', $warningCount)
                ->description('Total No Good Condition')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Card::make('Fire Extinguisher Remarks', $goodCount)
                ->description('Total Good Condition')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Total Report Fire Extinguisher', FireExtinguisher::query()->count())
                ->description('All reports from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}

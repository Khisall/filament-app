<?php

namespace App\Filament\App\Widgets;

use App\Models\Team;
use App\Models\Report;
use App\Models\HoseReel;
use App\Models\Maintenance;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class HoseReelOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $goodCount = HoseReel::where('condition', 'GOOD')->count();
        $warningCount = HoseReel::where('condition', 'NO GOOD')->count();
        
        return [
            Card::make('Hose Reel Remarks', $warningCount)
                ->description('Total No Good Condition')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Card::make('Hose Reel Remarks', $goodCount)
                ->description('Total Good Condition')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Total Report Hose Reel', HoseReel::query()->count())
                ->description('All reports from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}

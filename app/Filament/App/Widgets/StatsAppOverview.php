<?php

namespace App\Filament\App\Widgets;

use App\Models\Team;
use App\Models\Report;
use App\Models\Maintenance;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAppOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $goodCount = Report::where('condition', 'GOOD')->count();
        $warningCount = Report::where('condition', 'NO GOOD')->count();
        
        return [
            Card::make('Warning Remarks', $warningCount)
                ->description('Total Warning Remarks')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Card::make('Good Remarks', $goodCount)
                ->description('Total Good Remarks')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Reports', Report::query()->count())
                ->description('All reports from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}

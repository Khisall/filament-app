<?php

namespace App\Filament\Widgets;

use App\Models\Team;
use App\Models\User;
use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $goodCount = Report::where('condition', 'GOOD')->count();
        $warningCount = Report::where('condition', 'NO GOOD')->count();

        return [
            Card::make('No Good Remarks', $warningCount)
                ->description('Total No Good Condition')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Card::make('Good Remarks', $goodCount)
                ->description('Total Good Condition')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Reports', Report::query()->count())
                ->description('All reports from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}

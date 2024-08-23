<?php

namespace App\Filament\Widgets;

use App\Models\Team;
use App\Models\User;
use App\Models\Report;
use App\Models\HoseReel;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class HoseReelAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $goodCount = HoseReel::where('condition', 'GOOD')->count();
        $warningCount = HoseReel::where('condition', 'NO GOOD')->count();

        return [
            Card::make('Hose Reels Remark', $warningCount)
                ->description('Total No Good Condition')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Card::make('Hose Reels Remark', $goodCount)
                ->description('Total Good Condition')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Total Report Hose Reels', HoseReel::query()->count())
                ->description('All reports from the database')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('success'),
        ];
    }
}

<?php

namespace App\Filament\App\Widgets;

use App\Models\EmergencyLight;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EmergencyLightOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $goodCount = EmergencyLight::where('condition', 'GOOD')->count();
        $warningCount = EmergencyLight::where('condition', 'NO GOOD')->count();

        return [
            Card::make('Emergency Light Remarks', $warningCount)
                ->description('Total No Good Condition')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Card::make('Emergency Light Remarks', $goodCount)
                ->description('Total Good Condition')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Total Report Emergency Light', EmergencyLight::query()->count())
                ->description('All reports from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}

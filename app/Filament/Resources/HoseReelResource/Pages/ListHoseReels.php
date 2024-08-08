<?php

namespace App\Filament\Resources\HoseReelResource\Pages;

use Filament\Actions;
use App\Models\HoseReel;
use Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HoseReelResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListHoseReels extends ListRecords
{
    protected static string $resource = HoseReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'This Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_checking', '>=', now()->subWeek()))
                ->badge(HoseReel::query()->where('date_of_checking', '>=', now()->subWeek())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_checking', '>=', now()->subMonth()))
                ->badge(HoseReel::query()->where('date_of_checking', '>=', now()->subMonth())->count()),
            'This Year' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_checking', '>=', now()->subYear()))
                ->badge(HoseReel::query()->where('date_of_checking', '>=', now()->subYear())->count()),
        ];
    }
}

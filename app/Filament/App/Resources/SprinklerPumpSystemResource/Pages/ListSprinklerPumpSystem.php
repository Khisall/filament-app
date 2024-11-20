<?php

namespace App\Filament\App\Resources\SprinklerPumpSystemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\App\Resources\SprinklerPumpSystemResource;
use App\Filament\App\Resources\SprinklerPumpSystemResource\Pages\ListSprinklerPumpSystem;

class ListSprinklerPumpSystem extends ListRecords
{
    protected static string $resource = SprinklerPumpSystemResource::class;

    protected static string $view = 'filament.resources.sprinkler-pump-resource.pages.list-sprinkler-pump-system';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

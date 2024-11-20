<?php

namespace App\Filament\Resources\SprinklerPumpSystemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SprinklerPumpSystemResource;

class ListSprinklerPumpSystem extends ListRecords
{
    protected static string $resource = SprinklerPumpSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

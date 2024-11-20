<?php

namespace App\Filament\Resources\NewSprinklerPumpResource\Pages;

use App\Filament\Resources\NewSprinklerPumpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewSprinklerPumps extends ListRecords
{
    protected static string $resource = NewSprinklerPumpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

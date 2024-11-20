<?php

namespace App\Filament\Resources\NewEmergencyLightResource\Pages;

use App\Filament\Resources\NewEmergencyLightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewEmergencyLights extends ListRecords
{
    protected static string $resource = NewEmergencyLightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\EmergencyLightResource\Pages;

use App\Filament\Resources\EmergencyLightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmergencyLights extends ListRecords
{
    protected static string $resource = EmergencyLightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

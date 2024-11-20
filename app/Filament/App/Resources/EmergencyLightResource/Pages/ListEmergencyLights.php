<?php

namespace App\Filament\App\Resources\EmergencyLightResource\Pages;

use App\Filament\App\Resources\EmergencyLightResource;
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

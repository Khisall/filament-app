<?php

namespace App\Filament\App\Resources\EmergencyLightResource\Pages;

use App\Filament\App\Resources\EmergencyLightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmergencyLight extends EditRecord
{
    protected static string $resource = EmergencyLightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

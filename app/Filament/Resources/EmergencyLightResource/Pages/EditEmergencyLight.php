<?php

namespace App\Filament\Resources\EmergencyLightResource\Pages;

use App\Filament\Resources\EmergencyLightResource;
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

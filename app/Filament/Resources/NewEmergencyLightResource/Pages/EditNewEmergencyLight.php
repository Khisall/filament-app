<?php

namespace App\Filament\Resources\NewEmergencyLightResource\Pages;

use App\Filament\Resources\NewEmergencyLightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewEmergencyLight extends EditRecord
{
    protected static string $resource = NewEmergencyLightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

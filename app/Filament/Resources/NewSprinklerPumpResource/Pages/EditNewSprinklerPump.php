<?php

namespace App\Filament\Resources\NewSprinklerPumpResource\Pages;

use App\Filament\Resources\NewSprinklerPumpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewSprinklerPump extends EditRecord
{
    protected static string $resource = NewSprinklerPumpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\SprinklerPumpSystemResource\Pages;

use App\Filament\Resources\SprinklerPumpSystemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSprinklerPumpSystem extends EditRecord
{
    protected static string $resource = SprinklerPumpSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

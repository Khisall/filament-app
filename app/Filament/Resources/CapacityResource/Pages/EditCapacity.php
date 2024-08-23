<?php

namespace App\Filament\Resources\CapacityResource\Pages;

use App\Filament\Resources\CapacityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCapacity extends EditRecord
{
    protected static string $resource = CapacityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\CapacityResource\Pages;

use App\Filament\Resources\CapacityResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCapacity extends ViewRecord
{
    protected static string $resource = CapacityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

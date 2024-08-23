<?php

namespace App\Filament\Resources\DuedateResource\Pages;

use App\Filament\Resources\DuedateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDuedate extends ViewRecord
{
    protected static string $resource = DuedateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

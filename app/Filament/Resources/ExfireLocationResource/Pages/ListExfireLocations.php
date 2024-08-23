<?php

namespace App\Filament\Resources\ExfireLocationResource\Pages;

use App\Filament\Resources\ExfireLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExfireLocations extends ListRecords
{
    protected static string $resource = ExfireLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

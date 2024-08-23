<?php

namespace App\Filament\Resources\DuedateResource\Pages;

use App\Filament\Resources\DuedateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDuedates extends ListRecords
{
    protected static string $resource = DuedateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

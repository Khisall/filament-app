<?php

namespace App\Filament\Resources\ExlocationResource\Pages;

use App\Filament\Resources\ExlocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExlocations extends ListRecords
{
    protected static string $resource = ExlocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

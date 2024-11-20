<?php

namespace App\Filament\Resources\NewCompressorResource\Pages;

use App\Filament\Resources\NewCompressorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewCompressors extends ListRecords
{
    protected static string $resource = NewCompressorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

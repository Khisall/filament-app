<?php

namespace App\Filament\App\Resources\CompressorResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\App\Resources\CompressorResource;
use App\Filament\App\Resources\CompressorResource\Pages\ListCompressor;

class ListCompressor extends ListRecords
{
    protected static string $resource = CompressorResource::class;

    protected static string $view = 'filament.resources.compressor-resource.pages.list-compressor';
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

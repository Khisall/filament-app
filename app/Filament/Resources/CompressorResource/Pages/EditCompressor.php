<?php

namespace App\Filament\Resources\CompressorResource\Pages;

use App\Filament\Resources\CompressorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompressor extends EditRecord
{
    protected static string $resource = CompressorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

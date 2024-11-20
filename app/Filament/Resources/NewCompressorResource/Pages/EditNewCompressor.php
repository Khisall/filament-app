<?php

namespace App\Filament\Resources\NewCompressorResource\Pages;

use App\Filament\Resources\NewCompressorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewCompressor extends EditRecord
{
    protected static string $resource = NewCompressorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

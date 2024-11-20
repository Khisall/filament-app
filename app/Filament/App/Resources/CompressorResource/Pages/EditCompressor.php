<?php

namespace App\Filament\App\Resources\CompressorResource\Pages;

use Filament\Actions;
use Actions\CreateAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\App\Resources\CompressorResource;

class EditCompressor extends EditRecord
{
    protected static string $resource = CompressorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\CreateAction::make(),
        ];
    }
}

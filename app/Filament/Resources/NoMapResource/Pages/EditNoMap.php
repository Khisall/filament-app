<?php

namespace App\Filament\Resources\NoMapResource\Pages;

use App\Filament\Resources\NoMapResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNoMap extends EditRecord
{
    protected static string $resource = NoMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

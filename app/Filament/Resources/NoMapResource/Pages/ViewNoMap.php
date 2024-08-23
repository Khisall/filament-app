<?php

namespace App\Filament\Resources\NoMapResource\Pages;

use App\Filament\Resources\NoMapResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNoMap extends ViewRecord
{
    protected static string $resource = NoMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

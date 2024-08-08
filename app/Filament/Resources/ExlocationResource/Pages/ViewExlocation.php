<?php

namespace App\Filament\Resources\ExlocationResource\Pages;

use App\Filament\Resources\ExlocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExlocation extends ViewRecord
{
    protected static string $resource = ExlocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

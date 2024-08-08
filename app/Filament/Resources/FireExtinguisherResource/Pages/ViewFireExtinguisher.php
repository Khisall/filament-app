<?php

namespace App\Filament\Resources\FireExtinguisherResource\Pages;

use App\Filament\Resources\FireExtinguisherResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFireExtinguisher extends ViewRecord
{
    protected static string $resource = FireExtinguisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\App\Resources\FireExtinguisherResource\Pages;

use App\Filament\App\Resources\FireExtinguisherResource;
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

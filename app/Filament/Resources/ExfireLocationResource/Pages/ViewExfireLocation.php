<?php

namespace App\Filament\Resources\ExfireLocationResource\Pages;

use App\Filament\Resources\ExfireLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExfireLocation extends ViewRecord
{
    protected static string $resource = ExfireLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

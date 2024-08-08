<?php

namespace App\Filament\Resources\HoseReelResource\Pages;

use Filament\Actions;
use Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\App\HoseReelResource;

class ViewHoseReel extends ViewRecord
{
    protected static string $resource = HoseReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

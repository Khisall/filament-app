<?php

namespace App\Filament\App\Resources\HoseReelResource\Pages;

use App\Filament\App\Resources\HoseReelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHoseReel extends ViewRecord
{
    protected static string $resource = HoseReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

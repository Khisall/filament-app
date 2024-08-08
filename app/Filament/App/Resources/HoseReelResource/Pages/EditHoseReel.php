<?php

namespace App\Filament\App\Resources\HoseReelResource\Pages;

use App\Filament\App\Resources\HoseReelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHoseReel extends EditRecord
{
    protected static string $resource = HoseReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

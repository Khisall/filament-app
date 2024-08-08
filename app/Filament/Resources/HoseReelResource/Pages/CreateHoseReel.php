<?php

namespace App\Filament\Resources\HoseReelResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Filament\Resources\HoseReelResource;

class CreateHoseReel extends CreateRecord
{
    protected static string $resource = HoseReelResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Report created.')
            ->body('The Report created successfully.');
    }
}

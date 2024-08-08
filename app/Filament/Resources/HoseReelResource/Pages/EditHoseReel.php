<?php

namespace App\Filament\Resources\HoseReelResource\Pages;

use App\Filament\Resources\HoseReelResource;
use Filament\Actions;
use Filament\Notifications\Notification;
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

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Report updated.')
            ->body('The Report updated successfully.');
    }
}

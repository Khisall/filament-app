<?php

namespace App\Filament\App\Resources\HoseReelResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\App\Resources\HoseReelResource;

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
            ->title('Report updated.')
            ->body('The Report updated successfully.')
            ->sendToDatabase(auth()->user());
    }
}

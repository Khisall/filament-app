<?php

namespace App\Filament\Resources\FireExtinguisherResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\FireExtinguisherResource;

class EditFireExtinguisher extends EditRecord
{
    protected static string $resource = FireExtinguisherResource::class;

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

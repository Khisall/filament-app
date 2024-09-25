<?php

namespace App\Filament\Resources\FireExtinguisherResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FireExtinguisherResource;

class CreateFireExtinguisher extends CreateRecord
{
    protected static string $resource = FireExtinguisherResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Report created.')
            ->body('The Report created successfully.')
            ->sendToDatabase(auth()->user())
            ->send();
    }
}

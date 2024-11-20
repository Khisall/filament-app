<?php

namespace App\Filament\App\Resources\FireExtinguisherResource\Pages;

use Filament\Actions;
use App\Models\FireExtinguisher;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\App\Resources\FireExtinguisherResource;

class CreateFireExtinguisher extends CreateRecord
{
    protected static string $resource = FireExtinguisherResource::class;

    protected function handleRecordCreation(array $data): FireExtinguisher
    {
        $fireExtinguisher = parent::handleRecordCreation($data);

        $this->sendCreatedNotification($fireExtinguisher);

        return $fireExtinguisher;
    }

    protected function sendCreatedNotification(FireExtinguisher $fireExtinguisher): void
    {
        $user = auth()->user();

        $tube_condition = $fireExtinguisher->tube_condition;

        $name = $fireExtinguisher->name;

        $locationName = $fireExtinguisher->exfire_location;
        
        $createdAt = $fireExtinguisher->created_at->format('d/m/Y H:i');

        Notification::make()
            ->title('New Hose Reel Created')
            ->body("{$user->name} created a Fire Extinguisher Report by'{$fireExtinguisher->name}' in {$locationName} on {$createdAt} with condition: {$tube_condition}.")
            ->sendToDatabase($user)
            ->send();
    }
}

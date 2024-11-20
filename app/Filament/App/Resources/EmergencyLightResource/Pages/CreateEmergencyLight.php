<?php

namespace App\Filament\App\Resources\EmergencyLightResource\Pages;

use Filament\Actions;
use App\Models\EmergencyLight;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\App\Resources\EmergencyLightResource;

class CreateEmergencyLight extends CreateRecord
{
    protected static string $resource = EmergencyLightResource::class;

    protected function handleRecordCreation(array $data): EmergencyLight
    {
        $emergencyLight = parent::handleRecordCreation($data);

        $this->sendCreatedNotification($emergencyLight);

        return $emergencyLight;
    }

    protected function sendCreatedNotification(EmergencyLight $emergencyLight): void
    {
        $user = auth()->user();

        $condition = $emergencyLight->condition;

        $lt_name = $emergencyLight->lt_name;

        $map_no = $emergencyLight->map_no;

        $location = $emergencyLight->location;
        
        $createdAt = $emergencyLight->created_at->format('d/m/Y H:i');

        Notification::make()
            ->title('New Emergency Light Report Created')
            ->body("{$user->name} created a Emergency Light Report by '{$emergencyLight->lt_name}' in {$location} with No Map {$map_no} on {$createdAt} with condition: {$condition}.")
            ->sendToDatabase($user)
            ->send();
    }
}

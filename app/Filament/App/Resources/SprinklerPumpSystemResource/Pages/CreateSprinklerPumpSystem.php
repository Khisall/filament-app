<?php

namespace App\Filament\App\Resources\SprinklerPumpSystemResource\Pages;

use Filament\Actions;
use App\Models\SprinklerPumpSystem;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\App\Resources\SprinklerPumpSystemResource;

class CreateSprinklerPumpSystem extends CreateRecord
{
    protected static string $resource = SprinklerPumpSystemResource::class;

    protected function handleRecordCreation(array $data): SprinklerPumpSystem
    {
        $sprinklerPump = parent::handleRecordCreation($data);

        $this->sendCreatedNotification($sprinklerPump);

        return $sprinklerPump;
    }

    protected function sendCreatedNotification(SprinklerPumpSystem $sprinklerPump): void
    {
        $user = auth()->user();

        $equipment_name = $sprinklerPump->equipment_name;

        $code = $sprinklerPump->code;

        $activity = $sprinklerPump->activity;

        $name = $sprinklerPump->name;
        
        $createdAt = $sprinklerPump->created_at->format('d/m/Y H:i');

        Notification::make()
            ->title('New Sprinkler Pump Report Created')
            ->body("{$user->name} created a Sprinkler Pump Report in {$equipment_name} code {$code} doing activity {$activity}  on {$createdAt}")
            ->sendToDatabase($user)
            ->send();
    }
}

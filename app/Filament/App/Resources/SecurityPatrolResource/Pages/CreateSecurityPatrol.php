<?php

namespace App\Filament\App\Resources\SecurityPatrolResource\Pages;

use Filament\Actions;
use App\Models\SecurityPatrol;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\App\Resources\SecurityPatrolResource;

class CreateSecurityPatrol extends CreateRecord
{
    protected static string $resource = SecurityPatrolResource::class;

    protected function handleRecordCreation(array $data): SecurityPatrol
    {
        $securityPatrol = parent::handleRecordCreation($data);

        $this->sendCreatedNotification($securityPatrol);

        return $securityPatrol;
    }

    protected function sendCreatedNotification(SecurityPatrol $securityPatrol): void
    {
        $user = auth()->user();

        $status = $securityPatrol->status;

        $shift = $securityPatrol->shift;

        $area_main = $securityPatrol->area_main;

        $area_name = $securityPatrol->area_name;

        $status = $securityPatrol->status;
        
        $createdAt = $securityPatrol->created_at->format('d/m/Y H:i');

        Notification::make()
            ->title('New Security Patrol Report Created')
            ->body("{$user->name} created a Security Patrol Report in {$area_main} area {$area_name} shift:{$shift}  on {$createdAt} with status : {$status}.")
            ->sendToDatabase($user)
            ->send();
    }
}

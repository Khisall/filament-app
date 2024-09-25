<?php

namespace App\Filament\App\Resources\HoseReelResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\App\Resources\HoseReelResource;
use App\Models\HoseReel;

class CreateHoseReel extends CreateRecord
{
    protected static string $resource = HoseReelResource::class;

    protected function handleRecordCreation(array $data): HoseReel
    {
        $hoseReel = parent::handleRecordCreation($data);

        $this->sendCreatedNotification($hoseReel);

        return $hoseReel;
    }

    protected function sendCreatedNotification(HoseReel $hoseReel): void
    {
        $user = auth()->user();
        
        $condition = $hoseReel->condition;

        $name = $hoseReel->name;

        $locationName = $hoseReel->location->name;
        
        $createdAt = $hoseReel->created_at->format('d/m/Y H:i');

        Notification::make()
            ->title('New Hose Reel Created')
            ->body("{$user->name} created a Hose Reel Report by '{$hoseReel->name}' in {$locationName} on {$createdAt} with condition: {$condition}.")
            ->sendToDatabase($user);
    }
}

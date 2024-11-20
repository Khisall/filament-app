<?php

namespace App\Filament\App\Resources\CompressorResource\Pages;

use Filament\Actions;
use App\Models\Compressor;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Filament\App\Resources\CompressorResource;

class CreateCompressor extends CreateRecord
{
    protected static string $resource = CompressorResource::class;

    protected function handleRecordCreation(array $data): Compressor
    {
        $compressor = parent::handleRecordCreation($data);

        $this->sendCreatedNotification($compressor);

        return $compressor;
    }

    protected function sendCreatedNotification(Compressor $compressor): void
    {
        $user = auth()->user();

        $name = $compressor->name;

        $equipment_name = $compressor->equipment_name;
        
        $createdAt = $compressor->created_at->format('d/m/Y H:i');

        Notification::make()
            ->title('New Hose Reel Created')
            ->body("{$user->name} created a Compressor Report by'{$compressor->name}' at {$equipment_name} on {$createdAt}.")
            ->sendToDatabase($user)
            ->send();
    }
    
}

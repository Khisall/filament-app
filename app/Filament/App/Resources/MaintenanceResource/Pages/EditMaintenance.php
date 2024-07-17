<?php

namespace App\Filament\App\Resources\MaintenanceResource\Pages;

use App\Filament\App\Resources\MaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenance extends EditRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

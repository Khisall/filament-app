<?php

namespace App\Filament\Resources\SecurityPatrolResource\Pages;

use App\Filament\Resources\SecurityPatrolResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSecurityPatrol extends EditRecord
{
    protected static string $resource = SecurityPatrolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

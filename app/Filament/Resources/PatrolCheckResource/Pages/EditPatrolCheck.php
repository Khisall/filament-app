<?php

namespace App\Filament\Resources\PatrolCheckResource\Pages;

use App\Filament\Resources\PatrolCheckResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatrolCheck extends EditRecord
{
    protected static string $resource = PatrolCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

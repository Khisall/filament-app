<?php

namespace App\Filament\Resources\DuedateResource\Pages;

use App\Filament\Resources\DuedateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDuedate extends EditRecord
{
    protected static string $resource = DuedateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

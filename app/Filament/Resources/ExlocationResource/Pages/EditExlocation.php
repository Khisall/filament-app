<?php

namespace App\Filament\Resources\ExlocationResource\Pages;

use App\Filament\Resources\ExlocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExlocation extends EditRecord
{
    protected static string $resource = ExlocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

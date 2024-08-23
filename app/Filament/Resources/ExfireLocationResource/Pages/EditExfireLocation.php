<?php

namespace App\Filament\Resources\ExfireLocationResource\Pages;

use App\Filament\Resources\ExfireLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExfireLocation extends EditRecord
{
    protected static string $resource = ExfireLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

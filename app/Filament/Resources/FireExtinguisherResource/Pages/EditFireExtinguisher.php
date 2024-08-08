<?php

namespace App\Filament\Resources\FireExtinguisherResource\Pages;

use App\Filament\Resources\FireExtinguisherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFireExtinguisher extends EditRecord
{
    protected static string $resource = FireExtinguisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

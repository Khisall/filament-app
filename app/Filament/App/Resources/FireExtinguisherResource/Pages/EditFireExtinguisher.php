<?php

namespace App\Filament\App\Resources\FireExtinguisherResource\Pages;

use App\Filament\App\Resources\FireExtinguisherResource;
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

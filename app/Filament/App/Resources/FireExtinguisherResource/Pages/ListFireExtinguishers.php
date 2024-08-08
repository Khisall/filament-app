<?php

namespace App\Filament\App\Resources\FireExtinguisherResource\Pages;

use App\Filament\App\Resources\FireExtinguisherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFireExtinguishers extends ListRecords
{
    protected static string $resource = FireExtinguisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

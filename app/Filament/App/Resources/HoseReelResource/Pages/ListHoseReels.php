<?php

namespace App\Filament\App\Resources\HoseReelResource\Pages;

use App\Filament\App\Resources\HoseReelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHoseReels extends ListRecords
{
    protected static string $resource = HoseReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

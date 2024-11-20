<?php

namespace App\Filament\App\Resources\SecurityPatrolResource\Pages;

use App\Filament\App\Resources\SecurityPatrolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSecurityPatrols extends ListRecords
{
    protected static string $resource = SecurityPatrolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

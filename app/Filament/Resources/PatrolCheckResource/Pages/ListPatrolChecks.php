<?php

namespace App\Filament\Resources\PatrolCheckResource\Pages;

use App\Filament\Resources\PatrolCheckResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatrolChecks extends ListRecords
{
    protected static string $resource = PatrolCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

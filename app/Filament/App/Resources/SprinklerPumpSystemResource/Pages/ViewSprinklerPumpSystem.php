<?php

namespace App\Filament\App\Resources\SprinklerPumpSystemResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\InfoList;
use Filament\Infolists\Components\TextEntry;
use App\Filament\App\Resources\SprinklerPumpSystemResource;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;

class ViewSprinklerPumpSystem extends ViewRecord
{
    protected static string $resource = SprinklerPumpSystemResource::class;

    protected function getHeaderInfolists(): array
        {
            return [
                InfoList::make()
                    ->schema([
                        TextEntry::make('equipment_name')
                            ->label('Equipment Name'),
                        TextEntry::make('month')
                            ->label('Month'),
                        TextEntry::make('code')
                            ->label('Code'),
                        TextEntry::make('activity')
                            ->label('Activity'),
                        TextEntry::make('requirement')
                            ->label('Requirement'),
                        TextEntry::make('tools')
                            ->label('Tools'),
                        TextEntry::make('who')
                            ->label('Who'),
                        TextEntry::make('interval')
                            ->label('Interval'),
                        TextEntry::make('time')
                            ->label('Time (min)'),
                        SpatieMediaLibraryImageEntry::make('upload')
                            ->collection('images')
                            ->conversion('compressed')
                            ->label('Uploaded Image')
                            ->disk('public'),
                    ])
            ];
        }
}
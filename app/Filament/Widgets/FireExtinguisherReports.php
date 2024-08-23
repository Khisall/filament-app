<?php

namespace App\Filament\Widgets;
    
use Filament\Tables;
use Filament\Tables\Table;
use Tables\Columns\TextColumn;
use App\Models\FireExtinguisher;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\TableWidget as BaseWidget;

class FireExtinguisherReports extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(FireExtinguisher::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('no_map.name'),
                Tables\Columns\TextColumn::make('exfire_locations.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('date_of_checking'),
                Tables\Columns\TextColumn::make('tube_condition')
                    ->badge()
                        ->color(function(string $state) : string{
                            return match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger'
                            };
                        }),
                    ])
            
            ->actions([
                ViewAction::make()
                ->form([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('date_of_checking')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('tube_condition')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('tube_remark')
                        ->required()
                        ->maxLength(255),

                ]),
            ]);
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Report;
use App\Models\HoseReel;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ReportResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Infolists\Components\Actions\Action;

class HoseReelReports extends BaseWidget
{

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(HoseReel::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('location.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('date_of_checking'),
                Tables\Columns\TextColumn::make('condition')
                    ->badge()
                        ->color(function(string $state) : string{
                            return match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger'
                            };
                        }),
                Tables\Columns\TextColumn::make('condition_remark'),
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
                    TextInput::make('condition')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('condition_remark')
                        ->required()
                        ->maxLength(255),

                ]),
            ]);
    }
}

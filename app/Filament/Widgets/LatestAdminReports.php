<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Report;
use App\Filament\Resources\ReportResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Infolists\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;

class LatestAdminReports extends BaseWidget
{

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(Report::query())
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
                Tables\Columns\TextColumn::make('remark'),
                    ])
            
            ->actions([
                ViewAction::make()
                ->form([
                    TextInput::make('location.name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('date_of_checking')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('condition')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('remark')
                        ->required()
                        ->maxLength(255),

                ]),
            ]);
    }
}

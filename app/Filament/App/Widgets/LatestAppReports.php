<?php

namespace App\Filament\App\Widgets;

use Filament\Tables;
use App\Models\Report;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\App\Resources\ReportResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAppReports extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(Report::query()->whereBelongsTo(Filament::getTenant()))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('location.name'),
                TextColumn::make('name'),
                Tables\Columns\TextColumn::make('condition')
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger'
                            };
                        }),
                Tables\Columns\TextColumn::make('remark'),
                Tables\Columns\TextColumn::make('date_of_checking')
                    ])
                    ->actions([
                        Action::make('View')
                        ->url(fn (Report $record): string => ReportResource::getUrl('view',['record' => $record]))
            ]);
    }
}

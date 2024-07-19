<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Report;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\ReportResource;
use Filament\Widgets\TableWidget as BaseWidget;

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
                Action::make('View')
                ->url(fn (Report $record): string => ReportResource::getUrl('view',['record' => $record]))
            ]);
    }
}

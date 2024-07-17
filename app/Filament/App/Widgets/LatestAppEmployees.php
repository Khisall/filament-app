<?php

namespace App\Filament\App\Widgets;

use App\Models\Report;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAppReports extends BaseWidget
{
    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
            ->query(Report::query()->whereBelongsTo(Filament::getTenant()))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('location.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('remark')
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'Good' => 'success',
                            'Draft' => 'info',
                            'Warning' => 'danger'
                        };
                    })
            ]);
    }
}

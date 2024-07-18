<?php

namespace App\Filament\App\Widgets;

use Filament\Tables;
use App\Models\Report;
use Filament\Tables\Table;
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

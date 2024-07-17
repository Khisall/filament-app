<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Tables;
use Filament\Tables\Table;
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

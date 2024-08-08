<?php

namespace App\Filament\App\Widgets;

use Filament\Tables;
use App\Models\Report;
use App\Models\HoseReel;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\App\Resources\ReportResource;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\App\Resources\HoseReelResource;

class LatestAppReports extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(HoseReel::query()->whereBelongsTo(Filament::getTenant()))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('location.name'),
                TextColumn::make('maintenance.name'),
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
                        ->url(fn (HoseReel $record): string => HoseReelResource::getUrl('view',['record' => $record]))
                    ])

                    ->filters([
                        SelectFilter::make('Maintenance')
                            ->relationship('maintenance', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Filter by Maintenance')
                            ->indicator('Maintenance'),
                        Filter::make('created_at')
                            ->form([
                                DatePicker::make('created_from'),
                                DatePicker::make('created_until'),
                            ])
                            ->query(function (Builder $query, array $data): Builder {
                                return $query
                                    ->when(
                                        $data['created_from'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                    )
                                    ->when(
                                        $data['created_until'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                    );
                            })
                            ->indicateUsing(function (array $data): array {
                                $indicators = [];
                                if ($data['created_from'] ?? null) {
                                    $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                                }
                                if ($data['created_until'] ?? null) {
                                    $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                                }
        
                                return $indicators;
                            }),
                        ]);
    }
}

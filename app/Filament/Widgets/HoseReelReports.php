<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Report;
use App\Models\HoseReel;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
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

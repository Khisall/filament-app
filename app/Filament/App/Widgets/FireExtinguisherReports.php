<?php

namespace App\Filament\App\Widgets;
    
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Tables\Columns\TextColumn;
use App\Models\FireExtinguisher;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\App\Resources\FireExtinguisherResource;

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
                Tables\Columns\TextColumn::make('exfire_location'),
                Tables\Columns\TextColumn::make('maintenance.name'),
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
                Tables\Columns\TextColumn::make('tube_remark'),
                    ])
                    ->actions([
                        Action::make('View')
                        ->url(fn (FireExtinguisher $record): string => FireExtinguisherResource::getUrl('view',['record' => $record]))
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

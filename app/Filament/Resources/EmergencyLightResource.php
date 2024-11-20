<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use App\Models\EmergencyLight;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use App\Models\NewEmergencyLight;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Tables\Columns\SpatieMediaLibraryImageColumn;
use Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmergencyLightResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\EmergencyLightResource\RelationManagers;

class EmergencyLightResource extends Resource
{
    protected static ?string $model = EmergencyLight::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Report Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'warning' : 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Forms\Components\Select::make('maintenance_id')
                        ->relationship('maintenance', 'name', fn (Builder $query) => $query->where('resource_type', 'emergency_light'))
                        ->required(),
                    Forms\Components\TextInput::make('year')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('month')
                        ->label('Month')
                        ->options([
                            'January' => 'January',
                            'February' => 'February',
                            'March' => 'March',
                            'April' => 'April',
                            'May' => 'May',
                            'June' => 'June',
                            'July' => 'July',
                            'August' => 'August',
                            'September' => 'September',
                            'October' => 'October',
                            'November' => 'November',
                            'December' => 'December',
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('date_of_checking')
                        ->required(),
                ])->columns(2),

                Card::make([
                    Forms\Components\Select::make('map_no')
                        ->relationship(name: 'newEmergencyLight', titleAttribute: 'map_no')
                        ->searchable()
                        ->label('No Map')
                        ->preload()
                        ->live()
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $newEmergencyLight = NewEmergencyLight::find($state);
                            if ($newEmergencyLight) {
                                $set('location', $newEmergencyLight->location);
                                $set('type_light', $newEmergencyLight->type_light);
                            }
                        }),
                    Forms\Components\TextInput::make('location')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('type_light')
                        ->required()
                        ->maxLength(255),
                ])->columns(3),

                Card::make([
                    Forms\Components\Select::make('condition')
                        ->live()
                        ->options([
                            'GOOD' => 'GOOD',
                            'NO GOOD' => 'NO GOOD',
                        ]),
                    Forms\Components\TextInput::make('remark')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('photo')
                        ->collection('images')
                        ->disk('public')
                        ->multiple()
                        ->image()
                        ->label('Upload Files')
                        ->conversion('compressed')
                    ]),

                Card::make([
                    Forms\Components\TextInput::make('lt_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ae_name')
                        ->maxLength(255)
                        ->default(null),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('maintenance.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('month')->label('Month')->searchable(),
                Tables\Columns\TextColumn::make('date_of_checking')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('newEmergencyLight.map_no')
                    ->label('No Map')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_light')
                    ->searchable(),
                Tables\Columns\TextColumn::make('condition')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger'
                        };
                    }),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('photo')
                    ->disk('public')
                    ->collection('images')
                    ->conversion('compressed')
                    ->label('Photo'),
                Tables\Columns\TextColumn::make('lt_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ae_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmergencyLights::route('/'),
            'create' => Pages\CreateEmergencyLight::route('/create'),
            'edit' => Pages\EditEmergencyLight::route('/{record}/edit'),
        ];
    }
}

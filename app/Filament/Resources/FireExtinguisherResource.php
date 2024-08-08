<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Type;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Illuminate\Support\Carbon;
use App\Models\FireExtinguisher;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Pages\ListFireExtinguishers;
use Tables\Actions\CreateAction;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\FireExtinguisherResource\Pages;
use App\Filament\Resources\FireExtinguisherResource\RelationManagers;

class FireExtinguisherResource extends Resource
{
    protected static ?string $model = FireExtinguisher::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Report Management';

    protected static ?string $recordTitleAttribute = 'name';

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
                Forms\Components\Section::make('Locations')                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
                    ->schema([
                    Forms\Components\Select::make('ex_locations_id')
                        ->relationship(name: 'ex_locations', titleAttribute: 'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('types_id', null);
                        })
                        ->required(),
                    Forms\Components\Select::make('types_id')
                        ->options(fn (Get $get): Collection => Type::query()
                            ->where('ex_locations_id', $get('ex_locations_id'))
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->required(),
                    Forms\Components\TextInput::make('capacity')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('location')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('due_date')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('years')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('maintenance_id')
                        ->relationship(name: 'maintenance', titleAttribute: 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Name')
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    ])->columns(2),
                    Forms\Components\Section::make('Checking')
                    ->schema([
                        Forms\Components\Radio::make('hose')
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                            
                        ]),
                    Forms\Components\Section::make('Checking')
                    ->schema([
                        Forms\Components\Radio::make('seal_pin')
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                            
                        ]),
                Forms\Components\Section::make('Checking')
                    ->schema([
                    Forms\Components\TextInput::make('pressure')
                        ->required()
                        ->maxLength(255),
                    ]),
                    Forms\Components\Section::make('Checking')
                    ->schema([
                        Forms\Components\Radio::make('indicator_condition')
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                            
                        ]),
                Forms\Components\Section::make('Remark')
                    ->schema([
                    Forms\Components\TextInput::make('remark')
                        ->required()
                        ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Dates')
                        ->schema([
                            Forms\Components\DatePicker::make('date_of_checking')
                                ->native(false)
                                ->displayFormat('d/m/Y')
                                ->required(),
                        ])->columns(2),
                Forms\Components\SpatieMediaLibraryFileUpload::make('upload')
                    ->columns(1)
                    ->multiple()
                    ->directory('upload')
                    ->downloadable()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                        ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ex_locations.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('types.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('years')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintenance.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hose')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger'
                        };
                    }),
                Tables\Columns\TextColumn::make('seal_pin')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger'
                        };
                    }),
                Tables\Columns\TextColumn::make('pressure')
                    ->searchable(),
                Tables\Columns\TextColumn::make('indicator_condition')
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
                Tables\Columns\TextColumn::make('date_of_checking')
                    ->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('upload'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Relationships')
                    ->schema([
                        TextEntry::make('ex_locations.name'),
                        TextEntry::make('maintenance.name'),
                    ])->columns(2),
                Section::make('Name')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('date_of_checking')
                    ])
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
            'index' => Pages\ListFireExtinguishers::route('/'),
            'create' => Pages\CreateFireExtinguisher::route('/create'),
            //'view' => Pages\ViewFireExtinguisher::route('/{record}'),
            'edit' => Pages\EditFireExtinguisher::route('/{record}/edit'),
        ];
    }
}

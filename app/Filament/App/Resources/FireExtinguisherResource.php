<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use App\Models\Type;
use App\Models\Year;
use Filament\Tables;
use App\Models\Duedate;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Capacity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use App\Models\ExfireLocation;
use Illuminate\Support\Carbon;
use App\Models\FireExtinguisher;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Pages\ListFireExtinguishers;
use Tables\Actions\CreateAction;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Filament\Infolists\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\App\Resources\FireExtinguisherResource\Pages;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\App\Resources\FireExtinguisherResource\RelationManagers;

class FireExtinguisherResource extends Resource
{
    protected static ?string $model = FireExtinguisher::class;

    public static ?string $tenantRelationshipName = 'fireExtinguisher';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
                    ->schema([
                    Forms\Components\Select::make('no_map_id')
                        ->relationship(name: 'no_map', titleAttribute: 'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                            // Mengisi otomatis dropdown lainnya berdasarkan pilihan no_map_id
                            $types = Type::where('no_map_id', $state)->first();
                            $capacities = Capacity::where('no_map_id', $state)->first();
                            $exfireLocations = ExfireLocation::where('no_map_id', $state)->first();
                            $duedates = Duedate::where('no_map_id', $state)->first();
                            $years = Year::where('no_map_id', $state)->first();

                            // Mengatur nilai otomatis
                            $set('types_id', $types?->id);
                            $set('capacities_id', $capacities?->id);
                            $set('exfire_locations_id', $exfireLocations?->id);
                            $set('duedates_id', $duedates?->id);
                            $set('years_id', $years?->id);
                        })
                        ->required(),
                    Forms\Components\Select::make('types_id')
                        ->options(fn (Get $get) => Type::where('no_map_id', $get('no_map_id'))->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->disabled(), // Non-aktifkan dropdown jika tidak ingin dipilih ulang
                    Forms\Components\Select::make('capacities_id')
                        ->options(fn (Get $get) => Capacity::where('no_map_id', $get('no_map_id'))->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->disabled(),
                    Forms\Components\Select::make('exfire_locations_id')
                        ->options(fn (Get $get) => ExfireLocation::where('no_map_id', $get('no_map_id'))->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->disabled(),
                    Forms\Components\Select::make('duedates_id')
                        ->options(fn (Get $get) => Duedate::where('no_map_id', $get('no_map_id'))->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->disabled(),
                    Forms\Components\Select::make('years_id')
                        ->options(fn (Get $get) => Year::where('no_map_id', $get('no_map_id'))->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->disabled(),
                    Forms\Components\Select::make('maintenance_id')
                        ->relationship(name: 'maintenance', titleAttribute: 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    ])->columns(2),
                    Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('hose')
                            ->live()
                            ->required()
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                        Forms\Components\TextInput::make('hose_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('hose') !== 'NO GOOD'),
                    ])->columns(2),
                    Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('seal_pin')
                            ->live()
                            ->required()
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                        Forms\Components\TextInput::make('sealpin_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('seal_pin') !== 'NO GOOD'),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\TextInput::make('pressure')
                        ->required()
                        ->maxLength(255),
                    ]),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('indicator_condition')
                            ->live()
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                        Forms\Components\TextInput::make('indicator_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('indicator_condition') !== 'NO GOOD'),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('tube_condition')
                            ->live()
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                        Forms\Components\TextInput::make('tube_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('tube_condition') !== 'NO GOOD'),
                    ])->columns(2),
                Forms\Components\Card::make()
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
                Tables\Columns\TextColumn::make('no_map.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('types.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacities.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exfire_locations.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duedates.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('years.name')
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
                Tables\Columns\TextColumn::make('hose_remark')
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('sealpin_remark')
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('indicator_remark')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tube_condition')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger'
                        };
                    }),
                Tables\Columns\TextColumn::make('tube_remark')
                    ->searchable()
                    ->sortable(),
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
                Card::make()
                    ->schema([
                        TextEntry::make('no_map.name'),
                        TextEntry::make('types.name'),
                        TextEntry::make('capacities.name'),
                        TextEntry::make('exfire_locations.name'),
                        TextEntry::make('duedates.name'),
                        TextEntry::make('years.name'),
                        TextEntry::make('maintenance.name'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('date_of_checking')
                    ]),
                Card::make()
                    ->schema([
                        TextEntry::make('hose')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger',
                            }),
                        TextEntry::make('hose_remark'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('seal_pin')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger',
                            }),
                        TextEntry::make('sealpin_remark'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('pressure'),
                    ]),
                Card::make()
                    ->schema([
                        TextEntry::make('indicator_condition')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger',
                            }),
                        TextEntry::make('indicator_remark'),
                    ])->columns(2),
                Section::make('Image')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('upload')
                         ->hiddenLabel()
                         ->grow(false),
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
            'view' => Pages\ViewFireExtinguisher::route('/{record}'),
            'edit' => Pages\EditFireExtinguisher::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use App\Models\Type;
use App\Models\Year;
use Filament\Tables;
use App\Models\NoMap;
use App\Models\Duedate;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Capacity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Text;
use App\Models\ExfireLocation;
use Illuminate\Support\Carbon;
use App\Models\FireExtinguisher;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Pages\ListFireExtinguishers;
use Tables\Actions\CreateAction;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Card;
use Illuminate\Validation\Rules\Unique;
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
use RuelLuna\CanvasPointer\Forms\Components\CanvasPointerField;
use App\Filament\App\Resources\FireExtinguisherResource\RelationManagers;

class FireExtinguisherResource extends Resource
{
    protected static ?string $model = FireExtinguisher::class;

    public static ?string $tenantRelationshipName = 'fireExtinguisher';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Fire Extinguisher Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Card::make()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
                ->schema([
                    Select::make('status')
                    ->label('Status')
                    ->options(collect(FireExtinguisher::getMappingImages())->mapWithKeys(function ($url, $status) {
                        return [$status => $status]; // Menggunakan nama status sebagai opsi di dropdown
                    })->toArray())
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Ambil array dari fungsi getMappingImages()
                        $mappingImages = FireExtinguisher::getMappingImages();
                        
                        // Cek apakah pilihan ada di array mappingImages
                        if (isset($mappingImages[$state])) {
                            // Set URL gambar sesuai pilihan
                            $set('image_url', $mappingImages[$state]);
                        } else {
                            // Jika tidak ada, gunakan gambar default
                            $set('image_url', asset('images/default-image.png'));
                        }
                    }),

                    Textarea::make('image_url')
                        ->label('Image URL')
                        ->reactive()
                        ->disabled(),

                    CanvasPointerField::make('body_points')
                        ->label('Lay Out Fire Extinguisher')
                        ->pointRadius(10)
                        ->imageUrl(fn ($get) => $get('image_url'))
                        ->width(1170)
                        ->height(800)
                        ->required(),
                ]),
                Forms\Components\Card::make()                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
                    ->schema([
                        Forms\Components\Select::make('no_map_id')
                            ->unique(
                                table: 'fire_extinguishers',
                                column: 'no_map_id',
                                ignoreRecord: true,
                                modifyRuleUsing: fn (Unique $rule, callable $get) =>
                                    $rule->where('maintenance_id', $get('maintenance_id'))
                            )
                            ->label('No Map')
                            ->options(function (callable $get) {
                                $maintenanceId = $get('maintenance_id');

                                if ($maintenanceId) {
                                    // Filter hanya no_map yang belum digunakan untuk maintenance yang sama
                                    $existingNoMaps = FireExtinguisher::where('maintenance_id', $maintenanceId)
                                        ->pluck('no_map_id')
                                        ->toArray();

                                    return NoMap::whereNotIn('id', $existingNoMaps)
                                        ->pluck('name', 'id');
                                }

                                // Jika maintenance belum dipilih, kembalikan daftar kosong
                                return [];
                            })
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $noMap = NoMap::find($state);
                                if ($noMap) {
                                    $set('type', $noMap->type);
                                    $set('capacity', $noMap->capacity);
                                    $set('exfire_location', $noMap->exfire_location);
                                    $set('duedate', $noMap->duedate);
                                    $set('year', $noMap->year);
                                }
                            }),
                    Forms\Components\TextInput::make('type')
                        ->label('Type')
                        ->readonly(),
                    Forms\Components\TextInput::make('capacity')
                        ->label('Capacity')
                        ->readonly(),
                    Forms\Components\TextInput::make('exfire_location')
                        ->label('Exfire Location')
                        ->readonly(),
                    Forms\Components\TextInput::make('duedate')
                        ->label('Due Date')
                        ->readonly(),
                    Forms\Components\TextInput::make('year')
                        ->label('Year')
                        ->readonly(),
                    Forms\Components\Select::make('maintenance_id')
                        ->relationship('maintenance', 'name', fn (Builder $query) => $query->where('resource_type', 'fire_extinguisher'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (Forms\Components\Select $component, $state) {
                            $locationComponent = $component->getContainer()->getComponent('no_map_id');
                            if ($locationComponent) {
                                $locationComponent->validate();
                            }
                        })
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('LT Name')
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
                        ->label('Pressure/KG')
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
                        ->collection('images')
                        ->disk('public')
                        ->columns(1)
                        ->multiple()
                        ->downloadable()
                        ->image()
                        ->conversion('compressed')
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_map.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exfire_location')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duedate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
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
                Tables\Columns\SpatieMediaLibraryImageColumn::make('upload')
                    ->disk('public')
                    ->collection('images')
                    ->conversion('compressed'),
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
                        TextEntry::make('type'),
                        TextEntry::make('capacity'),
                        TextEntry::make('exfire_location'),
                        TextEntry::make('duedate'),
                        TextEntry::make('year'),
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
                Card::make()
                    ->schema([
                        TextEntry::make('tube_condition')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger',
                            }),
                        TextEntry::make('tube_remark'),
                    ])->columns(2),
                Section::make('Image')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('upload')
                            ->hiddenLabel()
                            ->grow(false)
                            ->conversion('compressed')
                            ->disk('public')
                            ->collection('images'),
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

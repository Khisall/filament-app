<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Pages\ViewCompressor;
use Filament\Tables\Table;
use App\Models\NewSprinklerPump;
use Filament\Resources\Resource;
use Tables\Columns\BooleanColumn;
use Pages\ListSprinklerPumpSystem;
use Pages\ViewSprinklerPumpSystem;
use App\Models\SprinklerPumpSystem;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Tables\Columns\SpatieMediaLibraryImageColumn;
use Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\App\Resources\SprinklerPumpSystemResource\Pages;
use App\Filament\App\Resources\SprinklerPumpSystemResource\RelationManagers;

class SprinklerPumpSystemResource extends Resource
{
    protected static ?string $model = SprinklerPumpSystem::class;

    public static ?string $tenantRelationshipName = 'sprinklerPump';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Sprinkler Pump Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('maintenance_id')
                        ->relationship('maintenance', 'name', fn (Builder $query) => $query->where('resource_type', 'sprinkler_pump_system'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (Forms\Components\Select $component, $state) {
                            $locationComponent = $component->getContainer()->getComponent('new_sprinkler_pump_system_id');
                            if ($locationComponent) {
                                $locationComponent->validate();
                            }
                        }),
                    Select::make('equipment_name')
                        ->label('Equipment Name')
                        ->options(NewSprinklerPump::pluck('equipment_name', 'equipment_name'))
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Reset kode ketika equipment_name berubah
                            $set('code', null);
                        })
                        ->required(),
                    Select::make('month')
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

                        Forms\Components\SpatieMediaLibraryFileUpload::make('upload')
                            ->collection('images')
                            ->disk('public')
                            ->columns(1)
                            ->multiple()
                            ->downloadable()
                            ->image()
                            ->conversion('compressed')
                ]),
                Card::make([
                    Select::make('code')
                        ->label('Code')
                        ->options(function (callable $get) {
                            $equipmentName = $get('equipment_name');
                            if ($equipmentName === 'Sprinkler Pump 1') {
                                // Tampilkan hanya kode B1 sampai B11
                                return NewSprinklerPump::where('equipment_name', 'Sprinkler Pump 1')
                                    ->whereIn('code', ['B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11'])
                                    ->pluck('code', 'code');
                            } elseif ($equipmentName === 'Sprinkler Pump 2') {
                                // Tampilkan hanya kode A1 sampai A11
                                return NewSprinklerPump::where('equipment_name', 'Sprinkler Pump 2')
                                    ->whereIn('code', ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11'])
                                    ->pluck('code', 'code');
                            }
                            return [];
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $newSprinklerPump = NewSprinklerPump::where('code', $state)->first();
                            if ($newSprinklerPump) {
                                $set('activity', $newSprinklerPump->activity);
                                $set('requirement', $newSprinklerPump->requirement);
                                $set('tools', $newSprinklerPump->tools);
                                $set('who', $newSprinklerPump->who);
                                $set('interval', $newSprinklerPump->interval);
                            }
                        }),
                        TextInput::make('activity')
                            ->label('Activities'),

                        TextInput::make('requirement')
                            ->label('Requirement')->readonly(),
                            ]),

                Card::make([
                    TextInput::make('tools')->label('Tools')->required()->readonly(),
                    TextInput::make('who')->label('Who')->required()->readonly(),
                    TextInput::make('interval')->label('Interval')->required()->readonly(),
                    TextInput::make('time')->label('Time (min)')->numeric()->required(),
                ]),

                Card::make([
                    Repeater::make('daily_checks')
                        ->label('Daily Checks')
                        ->grid(4)
                        ->schema([
                            Toggle::make('check')
                                ->label(fn ($get, $set) => 'Day ' . ($get('index'))) // Label sesuai urutan
                                ->afterStateHydrated(function ($set, $state, $get) {
                                    // Mengatur label berdasarkan urutan hari di repeater
                                    $index = $get('index') ?? 0;
                                    $dayNumber = $index + 1;
                                    $set('label', "Day {$dayNumber}");
                                })
                                ->default(false),
                        ])
                        ->columns(1) // Menampilkan Daily Checks satu per satu dalam card
                        ->defaultItems(31) // Mengatur jumlah item menjadi 31
                        ->disableItemCreation() // Mencegah penambahan item baru di luar 31 hari
                        ->disableItemDeletion(), // Mencegah penghapusan item untuk memastikan tetap 31 hari
                ])->columnSpan('full'),

                TextInput::make('name')->label('LT Record By')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('maintenance.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('equipment_name')->label('Equipment Name')->searchable(),
                TextColumn::make('month')->label('Month')->searchable(),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('upload')
                    ->disk('public')
                    ->collection('images')
                    ->conversion('compressed')
                    ->label('Photo'),
                        
                TextColumn::make('code')->label('Code')->searchable(),
                TextColumn::make('activity')->label('Activity'),
                TextColumn::make('requirement')->label('Requirment'),
                TextColumn::make('tools')->label('Tools'),
                TextColumn::make('who')->label('Who'),
                TextColumn::make('interval')->label('Interval'),
                TextColumn::make('time')->label('Time (min)'),

                ...array_map(
                    fn ($day) => Tables\Columns\BooleanColumn::make("daily_checks.{$day}.check")
                        ->label("Day {$day}")
                        ->getStateUsing(function ($record) use ($day) {
                            $dailyChecks = $record->daily_checks ?? [];
                
                            // Pastikan data berbentuk array dan cek status check
                            return isset($dailyChecks[$day - 1]) && ($dailyChecks[$day - 1]['check'] ?? false) === true;
                        })
                        ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                        ->toggleable(false),
                    range(1, 31)
                ),
            
                TextColumn::make('name')->label('LT Record By'),
            ])
            
            ->filters([
                // Filter untuk menampilkan hanya "Compressor 1"
                Filter::make('Compressor 1')
                    ->query(fn (Builder $query) => $query->where('equipment_name', 'Sprinkler Pump 1'))
                    ->label('Compressor 1'),

                // Filter untuk menampilkan hanya "Compressor 2"
                Filter::make('Compressor 2')
                    ->query(fn (Builder $query) => $query->where('equipment_name', 'Sprinkler Pump 2'))
                    ->label('Compressor 2'),
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
            'index' => Pages\ListSprinklerPumpSystem::route('/'),
            'create' => Pages\CreateSprinklerPumpSystem::route('/create'),
            'edit' => Pages\EditSprinklerPumpSystem::route('/{record}/edit'),
            'view' => Pages\ViewSprinklerPumpSystem::route('/{record}'),
        ];
    }
}

<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Pages\ViewCompressor;
use App\Models\Compressor;
use Filament\Tables\Table;
use App\Models\NewCompressor;
use Forms\Components\Fieldset;
use Tables\Columns\BadgeColumn;
use Filament\Resources\Resource;
use Tables\Columns\BooleanColumn;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Pages\CompressorTableComponent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\CompressorResource\Pages;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\App\Resources\CompressorResource\RelationManagers;

class CompressorResource extends Resource
{
    protected static ?string $model = Compressor::class;

    public static ?string $tenantRelationshipName = 'compressor';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Compressor Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Card::make([
                    Select::make('maintenance_id')
                        ->relationship('maintenance', 'name', fn (Builder $query) => $query->where('resource_type', 'compressor'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (Forms\Components\Select $component, $state) {
                            $locationComponent = $component->getContainer()->getComponent('new_compressor_id');
                            if ($locationComponent) {
                                $locationComponent->validate();
                            }
                        }),
                    Select::make('equipment_name')
                        ->label('Equipment Name')
                        ->options(NewCompressor::pluck('equipment_name', 'equipment_name'))
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
                        ->options(NewCompressor::whereIn('code', ['A1a', 'A1b', 'A1c','A2', 'A3', 'A4'])->pluck('code', 'code')) // Hanya menampilkan kode tertentu
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $newCompressor = NewCompressor::where('code', $state)->first();
                            if ($newCompressor) {
                                $set('activity', $newCompressor->activity);
                                $set('requirement', $newCompressor->requirement);
                                $set('tools', $newCompressor->tools);
                                $set('who', $newCompressor->who);
                                $set('interval', $newCompressor->interval);
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
                        ->grid(3)
                        ->schema([
                            Toggle::make('check')
                                ->label(fn ($get, $set) => 'Day ' . ($get('index') + 1)) // Label sesuai urutan
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
                    ->query(fn (Builder $query) => $query->where('equipment_name', 'Compressor 1'))
                    ->label('Compressor 1'),

                // Filter untuk menampilkan hanya "Compressor 2"
                Filter::make('Compressor 2')
                    ->query(fn (Builder $query) => $query->where('equipment_name', 'Compressor 2'))
                    ->label('Compressor 2'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCompressor::route('/'),
            'create' => Pages\CreateCompressor::route('/create'),
            'edit' => Pages\EditCompressor::route('/{record}/edit'),
            'view' => Pages\ViewCompressor::route('/{record}'),
        ];
    }
}

<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use App\Models\Type;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use App\Models\FireExtinguisher;
use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\FireExtinguisherResource\Pages;
use App\Filament\App\Resources\FireExtinguisherResource\RelationManagers;

class FireExtinguisherResource extends Resource
{
    protected static ?string $model = FireExtinguisher::class;

    public static ?string $tenantRelationshipName = 'fireExtinguisher';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Locations')
                    ->schema([
                    Forms\Components\Select::make('ex_locations_id')
                        ->relationship(name: 'exlocation', titleAttribute: 'name')
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
                Tables\Columns\TextColumn::make('exlocation.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('types.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('years')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('maintenance.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListFireExtinguishers::route('/'),
            'create' => Pages\CreateFireExtinguisher::route('/create'),
            'view' => Pages\ViewFireExtinguisher::route('/{record}'),
            'edit' => Pages\EditFireExtinguisher::route('/{record}/edit'),
        ];
    }
}

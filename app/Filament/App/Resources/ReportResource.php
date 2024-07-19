<?php

namespace App\Filament\App\Resources;

use badge;
use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Report;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Tables\Columns\ImageColumn;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Forms\Components\FileUpload;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\ReportResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\App\Resources\ReportResource\RelationManagers;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'warning' : 'good';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Locations')
                    ->schema([
                        Forms\Components\Select::make('location_id')
                            ->relationship(name: 'location', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
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
                    ])->columns(3),
                Forms\Components\Section::make('Checking')
                    ->schema([
                        Forms\Components\Select::make('free_obstruction')
                        ->options([
                            'NO' => 'No',
                            'YES' => 'Yes',
                        ]),
                        Forms\Components\Select::make('leakage')
                            ->options([
                                'NO' => 'No',
                                'YES' => 'Yes',
                            ]),
                        Forms\Components\Select::make('flush_test')
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                        ]),
                Forms\Components\Section::make('The Condition')
                    ->schema([
                        Forms\Components\Select::make('condition')
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                        ]),
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
                    ->directory('upload'),   

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('location.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('free_obstruction')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'YES' => 'success',
                            'NO' => 'danger'
                        };
                    }),
                Tables\Columns\TextColumn::make('leakage')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'YES' => 'danger',
                            'NO' => 'success'
                        };
                    }),
                Tables\Columns\TextColumn::make('flush_test')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger'
                        };
                    }),
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
                Tables\Columns\TextColumn::make('date_of_checking')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                        TextEntry::make('location.name'),
                        TextEntry::make('maintenance.name'),
                    ])->columns(2),
                Section::make('Name')
                    ->schema([
                        TextEntry::make('name'),
                    ])->columns(3),
                Section::make('Good Condition')
                    ->schema([
                        TextEntry::make('free_obstruction')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'NO' => 'danger',
                                'YES' => 'success',
                            }),
                        TextEntry::make('leakage')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'NO' => 'success',
                                'YES' => 'danger',
                            }),
                        TextEntry::make('flush_test')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger',
                            }),
                        ])->columns(3),
                Section::make('Remark')
                    ->schema([
                        TextEntry::make('condition')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger',
                        }),
                        TextEntry::make('remark'),
                        TextEntry::make('date_of_checking')
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}

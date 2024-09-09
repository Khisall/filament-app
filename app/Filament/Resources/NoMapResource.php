<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\NoMap;
use Pages\ListNoMaps;
use Filament\Forms\Form;
use App\Models\Exlocation;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NoMapResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NoMapResource\RelationManagers;
use App\Filament\Resources\NoMapResource\RelationManagers\FireExtinguisherRelationManager;

class NoMapResource extends Resource
{
    protected static ?string $model = NoMap::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'No Map';

    protected static ?string $navigationGroup = 'Fire Extinguisher Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('exfire_location')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('duedate')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('exfire_location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duedate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
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
            FireExtinguisherRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNoMaps::route('/'),
            'create' => Pages\CreateNoMap::route('/create'),
            'view' => Pages\ViewNoMap::route('/{record}'),
            'edit' => Pages\EditNoMap::route('/{record}/edit'),
        ];
    }
}

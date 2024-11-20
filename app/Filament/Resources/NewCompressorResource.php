<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewCompressorResource\Pages;
use App\Filament\Resources\NewCompressorResource\RelationManagers;
use App\Models\NewCompressor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewCompressorResource extends Resource
{
    protected static ?string $model = NewCompressor::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'New Compressor';

    protected static ?string $navigationGroup = 'Compressors Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('equipment_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('activity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('requirement')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tools')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('who')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('interval')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('equipment_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('activity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requirement')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tools')
                    ->searchable(),
                Tables\Columns\TextColumn::make('who')
                    ->searchable(),
                Tables\Columns\TextColumn::make('interval')
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
            'index' => Pages\ListNewCompressors::route('/'),
            'create' => Pages\CreateNewCompressor::route('/create'),
            'edit' => Pages\EditNewCompressor::route('/{record}/edit'),
        ];
    }
}

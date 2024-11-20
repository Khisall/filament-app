<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewSprinklerPumpResource\Pages;
use App\Filament\Resources\NewSprinklerPumpResource\RelationManagers;
use App\Models\NewSprinklerPump;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewSprinklerPumpResource extends Resource
{
    protected static ?string $model = NewSprinklerPump::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'New Sprinkler Pump';

    protected static ?string $navigationGroup = 'Sprinkler Pump Management';

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
            'index' => Pages\ListNewSprinklerPumps::route('/'),
            'create' => Pages\CreateNewSprinklerPump::route('/create'),
            'edit' => Pages\EditNewSprinklerPump::route('/{record}/edit'),
        ];
    }
}

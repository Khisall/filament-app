<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatrolCheckResource\Pages;
use App\Filament\Resources\PatrolCheckResource\RelationManagers;
use App\Models\PatrolCheck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatrolCheckResource extends Resource
{
    protected static ?string $model = PatrolCheck::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Security Check';

    protected static ?string $navigationGroup = 'Security Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('area_main')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('area_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('check_description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('area_main')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('check_description')
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
            'index' => Pages\ListPatrolChecks::route('/'),
            'create' => Pages\CreatePatrolCheck::route('/create'),
            'edit' => Pages\EditPatrolCheck::route('/{record}/edit'),
        ];
    }
}

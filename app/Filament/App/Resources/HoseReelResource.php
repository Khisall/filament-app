<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\HoseReel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Infolists\Components\Card;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\HoseReelResource\Pages;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\App\Resources\HoseReelResource\RelationManagers;

class HoseReelResource extends Resource
{
    protected static ?string $model = HoseReel::class;

    public static ?string $tenantRelationshipName = 'hoseReels';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Hose Reel Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('location_id')
                            ->relationship(name: 'location', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->unique(
                                table: 'hose_reels',
                                column: 'location_id',
                                ignoreRecord: true,
                                modifyRuleUsing: fn (Unique $rule, callable $get) => 
                                    $rule->where('maintenance_id', $get('maintenance_id'))
                            ),
                        Forms\Components\Select::make('maintenance_id')
                            ->relationship('maintenance', 'name', fn (Builder $query) => $query->where('resource_type', 'hose_reel'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->afterStateUpdated(function (Forms\Components\Select $component, $state) {
                                $locationComponent = $component->getContainer()->getComponent('location_id');
                                if ($locationComponent) {
                                    $locationComponent->validate();
                                }
                            })
                        ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('free_obstruction')
                            ->live()
                            ->required()
                            ->options([
                                'YES' => 'Yes',
                                'NO' => 'No',
                            ]),
                        Forms\Components\TextInput::make('obstruction_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('free_obstruction') !== 'NO'),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('leakage')
                            ->live()
                            ->required()
                            ->options([
                                'NO' => 'No',
                                'YES' => 'Yes',
                            ]),
                        Forms\Components\TextInput::make('leakage_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('leakage') !== 'YES'),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('flush_test')
                            ->live()
                            ->required()
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                            ]),
                        Forms\Components\TextInput::make('flush_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('flush_test') !== 'NO GOOD'),
                        ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Radio::make('condition')
                            ->required()
                            ->live()
                            ->options([
                                'GOOD' => 'GOOD',
                                'NO GOOD' => 'NO GOOD',
                        ]),
                        Forms\Components\TextInput::make('condition_remark')
                            ->nullable()
                            ->live()
                            ->hidden(fn (Get $get): bool => $get('condition') !== 'NO GOOD'),
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
                Tables\Columns\TextColumn::make('location.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintenance.name')
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
                Tables\Columns\TextColumn::make('obstruction_remark')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('leakage_remark')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('flush_remark')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('condition_remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_checking')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Card::make()
                    ->schema([
                        TextEntry::make('location.name'),
                        TextEntry::make('maintenance.name'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('date_of_checking')
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('leakage')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'NO' => 'success',
                                'YES' => 'danger',
                            }),
                        TextEntry::make('leakage_remark'),
                    ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('flush_test')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'GOOD' => 'success',
                                'NO GOOD' => 'danger',
                            }),
                        TextEntry::make('flush_remark'),
                        ])->columns(2),
                Card::make()
                    ->schema([
                        TextEntry::make('condition')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'GOOD' => 'success',
                            'NO GOOD' => 'danger',
                        }),
                        TextEntry::make('condition_remark'),
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
            'index' => Pages\ListHoseReels::route('/'),
            'create' => Pages\CreateHoseReel::route('/create'),
            'view' => Pages\ViewHoseReel::route('/{record}'),
            'edit' => Pages\EditHoseReel::route('/{record}/edit'),
        ];
    }
}

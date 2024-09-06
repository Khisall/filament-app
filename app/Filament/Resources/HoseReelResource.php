<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\HoseReel;
use Filament\Forms\Form;
use Pages\ListHoseReels;
use Filament\Tables\Table;
//use Forms\Components\Card;
use Illuminate\Support\Carbon;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\EditAction;
use Filament\Pages\Actions\ViewAction;
use Filament\Infolists\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\HoseReelResource\Pages;
use Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use App\Filament\Resources\HoseReelResource\RelationManagers;
use App\Filament\Resources\HoseReelResource\Pages\EditHoseReel;
use App\Filament\Resources\HoseReelResource\Pages\ViewHoseReel;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\Resources\HoseReelResource\Pages\CreateHoseReel;

class HoseReelResource extends Resource
{
    protected static ?string $model = HoseReel::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Report Management';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['location.name', 'name', 'condition_remark'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Location' => $record->location->name
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['location']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'warning' : 'success';
    }

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
                            ->relationship(name: 'maintenance', titleAttribute: 'name')
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
                Tables\Columns\TextColumn::make('maintenance.name')
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
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Report deleted.')
                            ->body('The Report deleted successfully.')
                    )
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
            //'create' => Pages\CreateHoseReel::route('/create'),
            //'view' => Pages\ViewHoseReel::route('/{record}'),
            'edit' => Pages\EditHoseReel::route('/{record}/edit'),
        ];
    }
}

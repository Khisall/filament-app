<?php

namespace App\Filament\App\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PatrolCheck;
use App\Models\SecurityPatrol;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\App\Resources\SecurityPatrolResource\Pages;
use App\Filament\App\Resources\SecurityPatrolResource\RelationManagers;

class SecurityPatrolResource extends Resource
{
    protected static ?string $model = SecurityPatrol::class;

    public static ?string $tenantRelationshipName = 'securityPatrol';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Security Patrol Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('maintenance_id')
                        ->relationship('maintenance', 'name', fn (Builder $query) => $query->where('resource_type', 'security_patrol'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (callable $set) {
                            $set('area_main', null); // Reset area_main
                            $set('area_name', null); // Reset area_name
                        }),

                    // Area Main
                    Select::make('area_main')
                        ->options([
                            'B1 AREA' => 'B1 AREA',
                            'B2 AREA' => 'B2 AREA',
                            'B3 AREA' => 'B3 AREA',
                        ])
                        ->label('Area')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('area_name', null)),
                ]),

                Card::make([
                    // Shift
                    Select::make('shift')
                        ->options([
                            '1st shift' => '1st shift',
                            '2nd shift' => '2nd shift',
                            '3rd shift' => '3rd shift',
                        ])
                        ->label('Shift')
                        ->required()
                        ->reactive(),

                    // Time
                    Select::make('time')
                        ->options(function (callable $get) {
                            $shift = $get('shift');
                            if ($shift === '1st shift') {
                                return [
                                    '08.00' => '08.00',
                                    '10.00' => '10.00',
                                    '12.00' => '12.00',
                                    '14.00' => '14.00',
                                ];
                            } elseif ($shift === '2nd shift') {
                                return [
                                    '16.00' => '16.00',
                                    '18.00' => '18.00',
                                    '20.00' => '20.00',
                                    '22.00' => '22.00',
                                ];
                            } elseif ($shift === '3rd shift') {
                                return [
                                    '24.00' => '24.00',
                                    '02.00' => '02.00',
                                    '04.00' => '04.00',
                                    '06.00' => '06.00',
                                ];
                            }
                            return [];
                        })
                        ->label('Time')
                        ->required()
                        ->reactive()
                        ->unique(
                            table: 'security_patrols',
                            column: 'time',
                            ignoreRecord: true,
                            modifyRuleUsing: fn (Unique $rule, callable $get) =>
                                $rule->where('shift', $get('shift'))
                                    ->where('area_name', $get('area_name'))
                        ),
                ]),

                Card::make([
                    // Area Name
                    Select::make('area_name')
                        ->options(function (callable $get) {
                            $selectedArea = $get('area_main');
                            $maintenanceId = $get('maintenance_id');
                            $shift = $get('shift');
                            $time = $get('time');

                            if ($selectedArea && $maintenanceId && $shift && $time) {
                                // Ambil area_name yang sudah digunakan untuk shift dan time yang sama
                                $existingAreaNames = SecurityPatrol::where('area_main', $selectedArea)
                                    ->where('maintenance_id', $maintenanceId)
                                    ->where('shift', $shift)
                                    ->where('time', $time)
                                    ->pluck('area_name')
                                    ->toArray();

                                return PatrolCheck::where('area_main', $selectedArea)
                                    ->whereNotIn('area_name', $existingAreaNames)
                                    ->distinct()
                                    ->pluck('area_name', 'area_name');
                            }

                            // Jika parameter belum lengkap
                            return [];
                        })
                        ->label('Area Name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (callable $get, callable $set) {
                            $areaMain = $get('area_main');
                            $areaName = $get('area_name');

                            if ($areaMain && $areaName) {
                                $checkDescriptions = PatrolCheck::where('area_main', $areaMain)
                                    ->where('area_name', $areaName)
                                    ->pluck('check_description');

                                // Pastikan ada dua deskripsi (EN dan ID)
                                if ($checkDescriptions->count() >= 2) {
                                    $set('check_description_en', $checkDescriptions[0]); // Bahasa Inggris
                                    $set('check_description_id', $checkDescriptions[1]); // Bahasa Indonesia
                                } else {
                                    $set('check_description_en', 'Description not available in English');
                                    $set('check_description_id', 'Deskripsi tidak tersedia dalam Bahasa Indonesia');
                                }
                            }
                        }),

                    // Check Description
                    Textarea::make('check_description_en')
                        ->label('Check Description (English)')
                        ->rows(4),

                    Textarea::make('check_description_id')
                        ->label('Check Description (Indonesian)')
                        ->rows(4),
                ]),

                Card::make([
                    // Status
                    Select::make('status')
                        ->options([
                            'OK' => 'OK',
                            'NG' => 'NG',
                        ])
                        ->label('Status')
                        ->default('OK')
                        ->required(),

                    // Checked At
                    DateTimePicker::make('checked_at')
                        ->label('Checked At')
                        ->default(now())
                        ->required(),

                    // Remarks
                    Textarea::make('remarks')
                        ->label('Remarks')
                        ->rows(3),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('area_main')
                    ->label('Area Main')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('area_name')
                    ->label('Area Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('check_description_en')
                    ->label('Check Description (English)')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('check_description_id')
                    ->label('Check Description (Indonesian)')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->color(function(string $state) : string{
                        return match ($state) {
                            'OK' => 'success',
                            'NG' => 'danger'
                        };
                    }),
                TextColumn::make('shift')
                    ->label('Shift')
                    ->sortable(),
                TextColumn::make('time')
                    ->label('Time')
                    ->sortable(),
                TextColumn::make('checked_at')
                    ->label('Checked At')
                    ->sortable(),
                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->limit(50),
            ])
            ->filters([
                SelectFilter::make('shift')
                    ->options([
                        '1st shift' => '1st shift',
                        '2nd shift' => '2nd shift',
                        '3rd shift' => '3rd shift',
                    ])
                    ->label('Shift'),
    
                SelectFilter::make('time')
                    ->options([
                        '08.00' => '08.00',
                        '10.00' => '10.00',
                        '12.00' => '12.00',
                        '14.00' => '14.00',
                        '16.00' => '16.00',
                        '18.00' => '18.00',
                        '20.00' => '20.00',
                        '22.00' => '22.00',
                        '24.00' => '24.00',
                        '02.00' => '02.00',
                        '04.00' => '04.00',
                        '06.00' => '06.00',
                    ])
                    ->label('Time'),
    
                SelectFilter::make('area_main')
                    ->options([
                        'B1 AREA' => 'B1 AREA',
                        'B2 AREA' => 'B2 AREA',
                        'B3 AREA' => 'B3 AREA',
                    ])
                    ->label('Area Main'),
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
            'index' => Pages\ListSecurityPatrols::route('/'),
            'create' => Pages\CreateSecurityPatrol::route('/create'),
            'edit' => Pages\EditSecurityPatrol::route('/{record}/edit'),
        ];
    }
}

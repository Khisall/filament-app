<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Maintenance;
use Forms\Components\Select;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MaintenanceResource\Pages;
use IbrahimBougaoua\FilaProgress\Tables\Columns\ProgressBar;
use IbrahimBougaoua\FilaProgress\Tables\Columns\CircleProgress;
use App\Filament\Resources\MaintenanceResource\RelationManagers;
use App\Filament\Resources\MaintenanceResource\Pages\EditMaintenance;
use App\Filament\Resources\MaintenanceResource\Pages\ListMaintenance;
use App\Filament\Resources\MaintenanceResource\Pages\ViewMaintenance;
use App\Filament\Resources\MaintenanceResource\Pages\CreateMaintenance;
use IbrahimBougaoua\FilaProgress\Infolists\Components\ProgressBarEntry;
use IbrahimBougaoua\FilaProgress\Infolists\Components\CircleProgressEntry;

class MaintenanceResource extends Resource
{
    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Maintenance';

    protected static ?string $modelLabel = 'Maintenance';

    protected static ?string $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Maintenance Name')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('resource_type')
                            ->label('Resource Type')
                            ->options([
                                'hose_reel' => 'Hose Reel',
                                'fire_extinguisher' => 'Fire Extinguisher',
                                'compressor' => 'Compressor',
                                'sprinkler_pump_system' => 'Sprinkler Pump',
                                'emergency_light' => 'Emergency Light',
                                'security_patrol' => 'Security Patrol',
                            ])
                            ->required()
                            ->label('Select Resource Type'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            
            // Kolom untuk menunjukkan target dan progress
            Tables\Columns\TextColumn::make('target')
                ->label('Target')
                ->getStateUsing(fn ($record) => $record->getTarget()),

            CircleProgress::make('circle')
                ->getStateUsing(fn ($record) => [
                    'total' => $record->getTarget(),
                    'progress' => $record->countItems(),
                ])
                ->hideProgressValue(false),
                
            ProgressBar::make('bar')
                ->getStateUsing(fn ($record) => [
                    'total' => $record->getTarget(),
                    'progress' => $record->countItems(),
                ])
                ->hideProgressValue(false),

            Tables\Columns\TextColumn::make('progress_percentage')
                ->label('Progress (%)')
                ->getStateUsing(fn ($record) => number_format($record->getProgress(), 2) . '%')
                ->sortable(),
            ])
            ->filters([
                SelectFilter::make('resource_type')
                    ->label('Resource Type')
                    ->options([
                        'hose_reel' => 'Hose Reel',
                        'fire_extinguisher' => 'Fire Extinguisher',
                        'compressor' => 'Compressor',
                        'sprinkler_pump_system' => 'Sprinkler Pump System',
                        'emergency_light' => 'Emergency Light',
                        'security_patrol' => 'Security Patrol',
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            CircleProgressEntry::make('circle')
                ->getStateUsing(function ($record) {
                    $total = 51; // Total target Hose Reel
                    $progress = $record->countItems(); // Jumlah record yang sudah selesai
                    return [
                        'total' => $total,
                        'progress' => $progress,
                    ];
                })
                ->hideProgressValue(false),
                
            ProgressBarEntry::make('bar')
                ->getStateUsing(function ($record) {
                    $total = 51;
                    $progress = $record->countItems();
                    return [
                        'total' => $total,
                        'progress' => $progress,
                    ];
                })
                ->hideProgressValue(false),
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
            'index' => Pages\ListMaintenance::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            //'view' => Pages\ViewMaintenance::route('/{record}'),
            //'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }
}

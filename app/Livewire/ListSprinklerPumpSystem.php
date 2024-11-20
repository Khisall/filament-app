<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\SprinklerPumpSystem;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ListSprinklerPumpSystem extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public string $equipment_name;

    public function mount($equipment_name)
    {
        $this->equipment_name = $equipment_name;
    }

    protected function getTableQuery()
    {
        return SprinklerPumpSystem::query()->where('equipment_name', $this->equipment_name);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('maintenance.name')->sortable()->searchable(),
            TextColumn::make('equipment_name')->label('Equipment Name')->searchable(),
            TextColumn::make('month')->label('Month')->searchable(),
            TextColumn::make('code')->label('Code')->searchable(),
            SpatieMediaLibraryImageColumn::make('upload')
                    ->disk('public')
                    ->collection('images')
                    ->conversion('compressed')
                    ->label('Photo'),
            TextColumn::make('activity')->label('Activity'),
            TextColumn::make('requirement')->label('Requirement'),
            TextColumn::make('tools')->label('Tools'),
            TextColumn::make('who')->label('Who'),
            TextColumn::make('interval')->label('Interval'),
            TextColumn::make('time')->label('Time (min)'),

            ...array_map(
                fn ($day) => TextColumn::make("daily_checks.{$day}.check")
                    ->label("Date {$day}")
                    ->getStateUsing(function ($record) use ($day) {
                        $dailyChecks = $record->daily_checks ?? [];
                        return isset($dailyChecks[$day - 1]) && ($dailyChecks[$day - 1]['check'] ?? false) === true ? 'GOOD' : 'NO GOOD';
                    })
                    ->color(fn ($state) => $state === 'GOOD' ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state === 'GOOD' ? 'OK' : 'X')
                    ->toggleable(false),
                range(1, 31)
            ),

            TextColumn::make('name')->label('LT Record By'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('maintenance_id')
                ->relationship('maintenance', 'name')
                ->searchable()
                ->preload()
                ->label('Filter by Maintenance'),

            SelectFilter::make('equipment_name')
                ->options(
                    SprinklerPumpSystem::distinct()->pluck('equipment_name', 'equipment_name')->toArray()
                )
                ->label('Compressor'),

            SelectFilter::make('month')
                ->options([
                    'January' => 'January',
                    'February' => 'February',
                    'March' => 'March',
                    'April' => 'April',
                    'May' => 'May',
                    'June' => 'June',
                    'July' => 'July',
                    'August' => 'August',
                    'September' => 'September',
                    'October' => 'October',
                    'November' => 'November',
                    'December' => 'December',
                ])
                ->label('Month'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
            ->url(fn ($record) => request()->is('admin/*')
                ? route('filament.admin.resources.sprinkler-pump-systems.edit', ['record' => $record->id])
                : route('filament.app.resources.sprinkler-pump-systems.edit', [
                    'tenant' => request()->route('tenant') ?? (auth()->user()->current_team->slug ?? 'default'),
                    'record' => $record->id
                ])
            ),

            ViewAction::make()
                ->url(fn ($record) => request()->is('admin/*')
                    ? route('filament.admin.resources.sprinkler-pump-systems.view', ['record' => $record->id])
                    : route('filament.app.resources.sprinkler-pump-systems.view', [
                        'tenant' => request()->route('tenant') ?? (auth()->user()->current_team->slug ?? 'default'),
                        'record' => $record->id
                    ])
                ),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
                DeleteBulkAction::make(),
                ExportBulkAction::make(),
        ];
    }
    
    public function render()
    {
        return view('livewire.list-sprinkler-pump-system', [
            'equipment_name' => $this->equipment_name,
        ]);
    }
}

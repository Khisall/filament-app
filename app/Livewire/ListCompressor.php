<?php

namespace App\Livewire;

use Livewire\Component;
use Pages\EditCompressor;
use App\Models\Compressor;
use Filament\Tables\Table;
use Pages\CreateCompressor;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ListCompressor extends Component implements HasForms, HasTable
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
        return Compressor::query()->where('equipment_name', $this->equipment_name);
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

            // Menambahkan kolom Day 1 hingga Day 31
            ...array_map(
                fn ($day) => TextColumn::make("daily_checks.{$day}.check")
                    ->label("Day {$day}")
                    ->getStateUsing(function ($record) use ($day) {
                        $dailyChecks = $record->daily_checks ?? [];
                        return isset($dailyChecks[$day - 1]) && ($dailyChecks[$day - 1]['check'] ?? false) === true ? 'GOOD' : 'NO GOOD';
                    })
                    ->color(fn ($state) => $state === 'GOOD' ? 'success' : 'danger')  // Warna hijau untuk "GOOD" dan merah untuk "NO GOOD" di UI
                    ->formatStateUsing(fn ($state) => $state === 'GOOD' ? 'OK' : 'X') // Hanya "OK" atau "X" yang akan diekspor
                    ->toggleable(false),
                range(1, 31)
            ),

            TextColumn::make('name')->label('LT Record By'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            // Filter berdasarkan Maintenance dengan SelectFilter
            SelectFilter::make('maintenance_id') // pastikan ini sesuai dengan kolom di database Anda
                ->relationship('maintenance', 'name') // Pastikan relasi maintenance ada di model
                ->searchable()
                ->preload()
                ->label('Filter by Maintenance'),

            // Filter berdasarkan Compressor
            SelectFilter::make('equipment_name') // ini harus sesuai dengan kolom di database
                ->options(
                    Compressor::distinct()->pluck('equipment_name', 'equipment_name')->toArray()
                )
                ->label('Compressor'),

            // Filter berdasarkan Month
            SelectFilter::make('month') // pastikan ini sesuai dengan kolom di database Anda
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
                ? route('filament.admin.resources.compressors.edit', ['record' => $record->id])
                : route('filament.app.resources.compressors.edit', [
                    'tenant' => request()->route('tenant') ?? (auth()->user()->current_team->slug ?? 'default'),
                    'record' => $record->id
                ])
            ),

            ViewAction::make()
                ->url(fn ($record) => request()->is('admin/*')
                    ? route('filament.admin.resources.compressors.view', ['record' => $record->id])
                    : route('filament.app.resources.compressors.view', [
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
        return view('livewire.list-compressor', [
            'equipment_name' => $this->equipment_name,
        ]);
    }
}

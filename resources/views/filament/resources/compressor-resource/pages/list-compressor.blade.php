<x-filament::page>
    <div class="space-y-6">
        @php
            $tenant = request()->route('tenant') ?? (auth()->user()->current_team->slug ?? 'default');
        @endphp
        
        @for ($i = 1; $i <= 27; $i++)
            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Compressors {{ $i }}</h2>
                    
                    @if (request()->is('admin/*'))
                        <a href="{{ route('filament.admin.resources.compressors.create') }}" class="btn btn-primary">
                        </a>
                    @else
                        <a href="{{ route('filament.app.resources.compressors.create', ['tenant' => $tenant]) }}" class="btn btn-primary">
                        </a>
                    @endif
                </div>

                @livewire('list-compressor', ['equipment_name' => 'Compressor ' . $i])
            </div>
        @endfor
    </div>
</x-filament::page>
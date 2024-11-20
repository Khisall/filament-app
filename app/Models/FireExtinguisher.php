<?php

namespace App\Models;

use App\Models\Maintenance;
use Spatie\Image\Enums\Fit;
use App\Models\FireExtinguisher;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\Events\MediaHasBeenProcessed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenSaved;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompletedEvent;

class FireExtinguisher extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'image_url', 'team_id','no_map_id', 'type', 'capacity', 'exfire_location', 'duedate', 'year', 'maintenance_id', 'name', 'hose', 'hose_remark', 'seal_pin', 'sealpin_remark', 'pressure', 'indicator_condition', 'indicator_remark', 'tube_condition', 'tube_remark', 'date_of_checking', 'upload',
    ];

    protected $casts =[
        'upload' => 'array',
    ];

    protected $mappingImages = [
        'B1 LOT 1-6' => 'mapping-1.png',
        'B2a LOT 12-17' => 'mapping-2.png',
        'B2a LOT 15-16' => 'mapping-3.png',
        'B2a LOT 1 & 11' => 'mapping-4.png',
        'B2a LOT 2' => 'mapping-5.png',
        'MCC LOT 3' => 'mapping-6.png',
        'B2a Lot 24 spray room (B3)' => 'mapping-7.png',
        'B2a Lot 20-24 (B3)' => 'mapping-8.png',
        'B2 Lot 12' => 'mapping-9.png',
        'B2 Lot 10-11' => 'mapping-10.png',
        'C2 Lot 1' => 'mapping-11.png',
    ];
    
    protected $guarded = [];

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function no_map(): BelongsTo
    {
        return $this->belongsTo(NoMap::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public static function rules($id = null)
    {
        return [
            'no_map_id' => 'required|unique:fire_extinguishers,no_map_id,' . $id,
            // other validation rules...
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('compressed')
            ->fit(Fit::Fill, 500, 300)
            ->nonQueued()
            ->performOnCollections('images');

            Event::listen(ConversionHasBeenCompletedEvent::class, function (ConversionHasBeenCompletedEvent $event) {
                $media = $event->media;
                
                $originalPath = $media->getPath();
                
                if (file_exists($originalPath)) {
                    unlink($originalPath);
                } else {
                }
            });
    }

    public static function getMappingImages()
    {
        return [
            'B1 LOT 1-6' => asset('images/mapping-1.png'),
            'B2a LOT 12-17' => asset('images/mapping-2.png'),
            'B2a LOT 15-16' => asset('images/mapping-3.png'),
            'B2a LOT 1 & 11' => asset('images/mapping-4.png'),
            'B2a LOT 2' => asset('images/mapping-5.png'),
            'MCC LOT 3' => asset('images/mapping-6.png'),
            'B2a Lot 24 spray room (B3)' => asset('images/mapping-7.png'),
            'B2a Lot 20-24 (B3)' => asset('images/mapping-8.png'),
            'B2 Lot 12' => asset('images/mapping-9.png'),
            'B2 Lot 10-11' => asset('images/mapping-10.png'),
            'C2 Lot 1' => asset('images/mapping-11.png'),
            'C2 Lot 5-6' => asset('images/mapping-12.png'),
        ];
    }

    public function render()
    {
        $status = $this->form->getState('status');
        $this->form->fill([
            'image_url' => FireExtinguisher::getMappingImages()[$status] ?? asset('images/default-image.png')
        ]);

        return view('livewire.create-fire-extinguisher');
    }
}

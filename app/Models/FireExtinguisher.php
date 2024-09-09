<?php

namespace App\Models;

use App\Models\Maintenance;
use Spatie\Image\Enums\Fit;
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
        'team_id','no_map_id', 'type', 'capacity', 'exfire_location', 'duedate', 'year', 'maintenance_id', 'name', 'hose', 'hose_remark', 'seal_pin', 'sealpin_remark', 'pressure', 'indicator_condition', 'indicator_remark', 'tube_condition', 'tube_remark', 'date_of_checking', 'upload',
    ];

    protected $casts =[
        'upload' => 'array'
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
            'no_map_id' => 'required|unique:fire_extinguisher,no_map_id,' . $id,
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
}

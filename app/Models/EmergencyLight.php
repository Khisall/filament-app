<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Maintenance;
use Spatie\Image\Enums\Fit;
use App\Models\NewEmergencyLight;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompletedEvent;

class EmergencyLight extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'maintenance_id',
        'year',
        'month',
        'date_of_checking',
        'map_no',
        'location',
        'type_light',
        'condition',
        'remark',
        'photo',
        'lt_name',
        'ae_name',
    ];

    protected $casts =[
        'photo' => 'array'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function newEmergencyLight(): BelongsTo
    {
        return $this->belongsTo(NewEmergencyLight::class, 'map_no', 'id');
    }
    
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
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

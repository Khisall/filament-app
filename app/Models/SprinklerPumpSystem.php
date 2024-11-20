<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Maintenance;
use Spatie\Image\Enums\Fit;
use App\Models\NewSprinklerPump;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompletedEvent;

class SprinklerPumpSystem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'equipment_name',
        'maintenance_id',
        'month',
        'photo',
        'code',
        'activity',
        'requirement',
        'tools',
        'who',
        'interval',
        'time',
        'daily_checks',
        'name'
    ];

    protected $casts = [
        'daily_checks' => 'array'
    ];

    public function getCheckForDay(int $day): bool
    {
        return isset($this->daily_checks[$day - 1]) ? $this->daily_checks[$day - 1]['check'] : false;
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function newsprinklerPump(): BelongsTo
    {
        return $this->belongsTo(NewSprinklerPump::class);
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

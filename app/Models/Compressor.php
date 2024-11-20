<?php

namespace App\Models;

use Log;
use App\Models\Team;
use App\Models\Unit;
use App\Models\Table;
use App\Models\Maintenance;
use Spatie\Image\Enums\Fit;
use App\Models\NewCompressor;
use Spatie\MediaLibrary\HasMedia;
use App\Models\CompressorActivity;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompletedEvent;

class Compressor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'compressors';
    
    protected $fillable = [
        'maintenance_id',
        'equipment_name',
        'month',
        'upload',
        'code',
        'activity',
        'requirement',
        'tools',
        'who',
        'interval',
        'time',
        'daily_checks',
        'name',
    ];
    

    protected $casts = [
        'daily_checks' => 'array', // Untuk menyimpan hasil cek harian dalam format array JSON
        'upload' => 'array'
    ];

    public function getCheckForDay(int $day): bool
    {
        return isset($this->daily_checks[$day - 1]) ? $this->daily_checks[$day - 1]['check'] : false;
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function newCompressor(): BelongsTo
    {
        return $this->belongsTo(NewCompressor::class);
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

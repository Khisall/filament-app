<?php

namespace App\Models;

use Log;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompletedEvent;

class HoseReel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [ 
        'location_id', 'maintenance_id', 'name', 'free_obstruction','obstruction_remark', 'condition', 'leakage','leakage_remark', 'flush_test','flush_remark', 'date_of_checking', 'condition_remark', 'upload',
    ];

    protected $casts =[
        'upload' => 'array'
    ];
    
    
    protected $guarded = [];

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public static function rules($id = null)
    {
        return [
            'location_id' => 'required|unique:hose_reels,location_id,' . $id,
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

<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
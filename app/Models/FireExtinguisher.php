<?php

namespace App\Models;

use App\Models\Maintenance;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FireExtinguisher extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'team_id','no_map_id', 'types_id', 'capacities_id', 'exfire_locations_id', 'duedates_id', 'years_id', 'maintenance_id', 'name', 'hose', 'hose_remark', 'seal_pin', 'sealpin_remark', 'pressure', 'indicator_condition', 'indicator_remark', 'tube_condition', 'tube_remark', 'date_of_checking', 'upload',
    ];

    protected $casts =[
        'upload' => 'array'
    ];
    
    protected $guarded = [];

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function exfire_locations(): BelongsTo
    {
        return $this->belongsTo(ExfireLocation::class);
    }

    public function no_map(): BelongsTo
    {
        return $this->belongsTo(NoMap::class);
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function years(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function duedates(): BelongsTo
    {
        return $this->belongsTo(Duedate::class);
    }

    public function capacities(): BelongsTo
    {
        return $this->belongsTo(Capacity::class);
    }

    public static function rules($id = null)
    {
        return [
            'no_map_id' => 'required|unique:fire_extinguisher,no_map_id,' . $id,
            // other validation rules...
        ];
    }
}

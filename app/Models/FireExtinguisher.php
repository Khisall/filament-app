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
        'team_id','ex_locations_id', 'types_id', 'capacity', 'location', 'due_date', 'years', 'maintenance_id', 'name', 'hose', 'seal_pin', 'pressure', 'indicator_condition', 'remark', 'date_of_checking', 'upload',
    ];

    protected $casts =[
        'upload' => 'array'
    ];
    
    protected $guarded = [];

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function ex_locations(): BelongsTo
    {
        return $this->belongsTo(Exlocation::class);
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

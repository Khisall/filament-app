<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'no_map_id',
        'name'
    ];

    public function no_map(): BelongsTo
    {
        return $this->belongsTo(NoMap::class);
    }

    public function fire_extinguishers(): Hasmany
    {
        return $this->hasMany(FireExtinguisher::class);
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}
    

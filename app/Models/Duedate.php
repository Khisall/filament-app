<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duedate extends Model
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

        public function exfire_locations(): BelongsTo
        {
            return $this->belongsTo(ExfireLocation::class);
        }

        public function fire_extinguishers(): HasMany
        {
            return $this->hasMany(FireExtinguisher::class);
        }

        public function maintenance(): HasMany
        {
            return $this->hasMany(Maintenance::class);
        }
}

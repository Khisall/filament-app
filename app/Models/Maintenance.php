<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'team_id'
    ];

    public function hoseReels(): HasMany
    {
        return $this->hasMany(HoseReel::class);
    }

    public function fireextinguisher(): HasMany
    {
        return $this->hasMany(FireExtinguisher::class);
    }

    public function no_map(): HasMany
    {
        return $this->hasMany(NoMap::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

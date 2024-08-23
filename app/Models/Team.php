<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];


    public function maintenancesHR(): HasMany
    {
        return $this->hasMany(HoseReel::class);
    }

    public function hoseReels(): HasMany
    {
        return $this->hasMany(HoseReel::class);
    }

    public function no_map(): HasMany
    {
        return $this->hasMany(NoMap::class);
    }

    public function fireExtinguisher(): HasMany
    {
        return $this->hasMany(FireExtinguisher::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function maintenancesFE(): HasMany
    {
        return $this->hasMany(HoseReel::class);
    }
}

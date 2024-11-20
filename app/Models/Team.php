<?php

namespace App\Models;


use App\Models\NoMap;
use App\Models\HoseReel;
use App\Models\Compressor;
use Illuminate\Support\Str;
use App\Models\EmergencyLight;
use App\Models\FireExtinguisher;
use App\Models\SprinklerPumpSystem;
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

    public function compressor(): HasMany
    {
        return $this->hasMany(Compressor::class);
    }

    public function sprinklerPump(): HasMany
    {
        return $this->hasMany(SprinklerPumpSystem::class);
    }

    public function emergencyLight(): HasMany
    {
        return $this->hasMany(EmergencyLight::class);
    }

    public function securityPatrol(): HasMany
    {
        return $this->hasMany(SecurityPatrol::class);
    }
}

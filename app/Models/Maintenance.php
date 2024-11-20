<?php

namespace App\Models;

use App\Models\Team;
use App\Models\NoMap;
use App\Models\HoseReel;
use App\Models\Compressor;
use App\Models\NewCompressor;
use App\Models\EmergencyLight;
use App\Models\SecurityPatrol;
use App\Models\FireExtinguisher;
use App\Models\NewSprinklerPump;
use App\Models\SprinklerPumpSystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'team_id', 'resource_type'
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

    public function new_compressor(): HasMany
    {
        return $this->hasMany(NewCompressor::class);
    }

    public function compressors(): HasMany
    {
        return $this->hasMany(Compressor::class);
    }

    public function sprinklerPump(): HasMany
    {
        return $this->hasMany(SprinklerPumpSystem::class);
    }

    public function newsprinklerPump(): HasMany
    {
        return $this->hasMany(NewSprinklerPump::class);
    }

    public function emergencyLight(): HasMany
    {
        return $this->hasMany(EmergencyLight::class);
    }

    public function securityPatrol(): HasMany
    {
        return $this->hasMany(SecurityPatrol::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function items()
    {
        return $this->hasMany(HoseReel::class); // Relasi yang kamu pakai
    }

    public function countItems(): int
    {
        return match ($this->resource_type) {
            'fire_extinguisher' => $this->fireextinguisher()->count(),
            'hose_reel' => $this->hoseReels()->count(),
            'compressor' => $this->compressors()->count(),
            'sprinkler_pump_system' => $this->sprinklerPump()->count(),
            'emergency_light' => $this->emergencyLight()->count(),
            'security_patrol' => $this->securityPatrol()->count(),
            default => 0,
        };
    }

    public function getProgress(): float
    {
        $target = $this->getTarget();
        $count = $this->countItems();

        return $target > 0 ? ($count / $target) * 100 : 0;
    }

    public function getTarget(): int
    {
        return match ($this->resource_type) {
            'fire_extinguisher' => 340,
            'hose_reel' => 51,
            'compressor' => 162,
            'sprinkler_pump_system' => 22,
            'emergency_light' => 196,
            'security_patrol' => 19,
            default => 0,
        };
    }
}

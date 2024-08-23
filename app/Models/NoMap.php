<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoMap extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code'
    ];

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function fire_extinguishers(): HasMany
    {
        return $this->hasMany(FireExtinguisher::class);
    }

    public function exfire_location(): HasMany
    {
        return $this->hasMany(ExfireLocation::class);
    }

    public function capacity(): HasMany
    {
        return $this->hasMany(Capacity::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(Year::class);
    }

    public function duedates(): HasMany
    {
        return $this->hasMany(Duedate::class);
    }
}
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
        'code',
        'type',
        'capacity',
        'exfire_location',
        'year',
        'duedate',
    ];

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function fire_extinguishers(): HasMany
    {
        return $this->hasMany(FireExtinguisher::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function hoseReels(): HasMany
    {
        return $this->hasMany(HoseReels::class);
    }

    public function type(): HasMany
    {
        return $this->hasMany(Type::class);
    }
    
}

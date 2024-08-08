<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExLocation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code'
    ];

    public function type(): HasMany
    {
        return $this->hasMany(Type::class);
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function fireExtinguisher(): HasMany
    {
        return $this->hasMany(FireExtinguisher::class);
    }
}
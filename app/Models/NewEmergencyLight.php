<?php

namespace App\Models;

use App\Models\EmergencyLight;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewEmergencyLight extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_map',
        'location',
        'type_light',
    ];

    public function emergencyLight(): HasMany
    {
        return $this->hasMany(EmergencyLight::class);
    }
}

<?php

namespace App\Models;

use App\Models\SprinklerPumpSystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewSprinklerPump extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_name',
        'code',
        'activity',
        'requirement',
        'tools',
        'who',
        'interval',
    ];

    public function sprinklerPump(): HasMany
    {
        return $this->hasMany(SprinklerPumpSystem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ex_locations_id',
        'name'
    ];

    public function ex_locations(): BelongsTo
    {
        return $this->belongsTo(Exlocation::class);
    }

    public function fireExtinguisers(): BelongsTo
    {
        return $this->belongsTo(FireExtinguisher::class);
    }

    public function maintenance(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
    

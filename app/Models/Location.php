<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}

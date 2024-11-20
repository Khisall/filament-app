<?php

namespace App\Models;

use App\Models\Maintenance;
use App\Models\SecurityPatrol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatrolCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_main',
        'area_name',
        'check_description',
    ];

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function securityPatrol(): HasMany
    {
        return $this->hasMany(SecurityPatrol::class);
    }
}

<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Maintenance;
use App\Models\PatrolCheck;
use App\Models\SecurityPatrol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecurityPatrol extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'area_main',
        'area_name',
        'check_description_en',
        'check_description_id',
        'status',
        'shift',
        'time',
        'checked_at',
        'remarks',
    ];

    public function maintenance(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function patrolCheck(): HasMany
    {
        return $this->hasMany(PatrolCheck::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $exists = SecurityPatrol::where('shift', $model->shift)
                ->where('time', $model->time)
                ->where('area_name', $model->area_name)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'time' => 'The selected time has already been used in this shift for the selected area.',
                ]);
            }
        });
    }
}

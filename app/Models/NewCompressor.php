<?php

namespace App\Models;

use App\Models\Compressor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewCompressor extends Model
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

    public function compressors(): HasMany
    {
        return $this->hasMany(Compressor::class);
    }
}

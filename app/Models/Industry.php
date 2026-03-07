<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    /** @use HasFactory<\Database\Factories\IndustryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(CompanyProfile::class);
    }

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(AgencyProfile::class, 'agency_industry')->withTimestamps();
    }
}

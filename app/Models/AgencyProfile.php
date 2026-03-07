<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgencyProfile extends Model
{
    /** @use HasFactory<\Database\Factories\AgencyProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agency_name',
        'contact_person',
        'email',
        'phone',
        'website',
        'city',
        'country',
        'about',
        'years_experience',
        'portfolio_links',
        'minimum_budget',
        'team_size',
        'pricing_style',
        'logo_path',
        'is_complete',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'portfolio_links' => 'array',
            'minimum_budget' => 'decimal:2',
            'is_complete' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'agency_service')->withTimestamps();
    }

    public function industries(): BelongsToMany
    {
        return $this->belongsToMany(Industry::class, 'agency_industry')->withTimestamps();
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'agency_id', 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'proposal_id',
        'company_id',
        'agency_id',
        'rating',
        'comment',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agency_id');
    }
}

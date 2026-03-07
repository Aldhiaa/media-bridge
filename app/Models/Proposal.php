<?php

namespace App\Models;

use App\Enums\ProposalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proposal extends Model
{
    /** @use HasFactory<\Database\Factories\ProposalFactory> */
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'agency_id',
        'proposed_price',
        'strategy_summary',
        'execution_timeline',
        'relevant_experience',
        'notes',
        'status',
        'is_revision',
        'submitted_at',
        'shortlisted_at',
        'accepted_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'proposed_price' => 'decimal:2',
            'status' => ProposalStatus::class,
            'is_revision' => 'boolean',
            'submitted_at' => 'datetime',
            'shortlisted_at' => 'datetime',
            'accepted_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ProposalAttachment::class);
    }

    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class);
    }

    public function canBeUpdatedByAgency(): bool
    {
        return in_array($this->status, [ProposalStatus::Submitted, ProposalStatus::Shortlisted], true);
    }
}

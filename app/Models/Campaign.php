<?php

namespace App\Models;

use App\Enums\CampaignStatus;
use App\Enums\ProposalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Campaign extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'industry_id',
        'title',
        'objective',
        'description',
        'target_audience',
        'required_deliverables',
        'budget',
        'start_date',
        'end_date',
        'proposal_deadline',
        'allow_proposal_updates',
        'status',
        'is_featured',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'proposal_deadline' => 'date',
            'allow_proposal_updates' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'status' => CampaignStatus::class,
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(CampaignChannel::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(CampaignAttachment::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function favoredByAgencies(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_favorites', 'campaign_id', 'agency_id')->withTimestamps();
    }

    public function acceptedProposal(): HasOne
    {
        return $this->hasOne(Proposal::class)->where('status', ProposalStatus::Accepted->value);
    }

    public function canReceiveProposals(): bool
    {
        return $this->status?->allowsProposals() && ! $this->proposal_deadline?->isPast();
    }

    public function scopeOpenForAgencies(Builder $query): Builder
    {
        return $query
            ->whereIn('status', [CampaignStatus::Published->value, CampaignStatus::ReceivingProposals->value])
            ->whereDate('proposal_deadline', '>=', now()->toDateString());
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['q'] ?? null, fn (Builder $q, string $value) => $q->where(function (Builder $inner) use ($value): void {
                $inner->where('title', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%");
            }))
            ->when($filters['category_id'] ?? null, fn (Builder $q, string $value) => $q->where('category_id', $value))
            ->when($filters['industry_id'] ?? null, fn (Builder $q, string $value) => $q->where('industry_id', $value))
            ->when($filters['status'] ?? null, fn (Builder $q, string $value) => $q->where('status', $value))
            ->when($filters['budget_min'] ?? null, fn (Builder $q, string $value) => $q->where('budget', '>=', $value))
            ->when($filters['budget_max'] ?? null, fn (Builder $q, string $value) => $q->where('budget', '<=', $value))
            ->when($filters['deadline_before'] ?? null, fn (Builder $q, string $value) => $q->whereDate('proposal_deadline', '<=', $value));
    }
}

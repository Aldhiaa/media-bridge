<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Conversation extends Model
{
    /** @use HasFactory<\Database\Factories\ConversationFactory> */
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'proposal_id',
        'company_id',
        'agency_id',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
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

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $builder) use ($user): void {
            $builder->where('company_id', $user->id)
                ->orWhere('agency_id', $user->id);
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'campaign_id',
        'proposal_id',
        'type',
        'subject',
        'details',
        'status',
        'resolved_by',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}

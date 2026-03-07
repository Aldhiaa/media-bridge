<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'body',
        'attachment_path',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopeUnreadFor(Builder $query, User $user): Builder
    {
        return $query
            ->where('is_read', false)
            ->where('sender_id', '!=', $user->id)
            ->whereHas('conversation', fn (Builder $builder) => $builder->forUser($user));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\ProposalAttachmentFactory> */
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}

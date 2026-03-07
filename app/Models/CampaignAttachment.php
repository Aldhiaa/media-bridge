<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignAttachmentFactory> */
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'uploaded_by',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}

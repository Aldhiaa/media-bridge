<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'brand_name',
        'contact_person',
        'email',
        'phone',
        'website',
        'industry_id',
        'city',
        'country',
        'description',
        'logo_path',
        'is_complete',
    ];

    protected function casts(): array
    {
        return [
            'is_complete' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }
}

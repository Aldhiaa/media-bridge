<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'status',
        'phone',
        'city',
        'country',
        'avatar_path',
        'last_login_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => Role::class,
            'status' => UserStatus::class,
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function companyProfile(): HasOne
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function agencyProfile(): HasOne
    {
        return $this->hasOne(AgencyProfile::class);
    }

    public function companyCampaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'company_id');
    }

    public function agencyProposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'agency_id');
    }

    public function favoriteCampaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, 'campaign_favorites', 'agency_id', 'campaign_id')->withTimestamps();
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function companyConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'company_id');
    }

    public function agencyConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'agency_id');
    }

    public function filedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function assignedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'resolved_by');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'company_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'agency_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    public function isCompany(): bool
    {
        return $this->role === Role::Company;
    }

    public function isAgency(): bool
    {
        return $this->role === Role::Agency;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active;
    }

    public function dashboardRouteName(): string
    {
        return match ($this->role) {
            Role::Admin => 'admin.dashboard',
            Role::Company => 'company.dashboard',
            Role::Agency => 'agency.dashboard',
        };
    }
}

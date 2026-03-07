<?php

namespace App\Policies;

use App\Enums\CampaignStatus;
use App\Models\Campaign;
use App\Models\User;

class CampaignPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Campaign $campaign): bool
    {
        if ($user->isAdmin() || $campaign->company_id === $user->id) {
            return true;
        }

        if ($user->isAgency()) {
            return $campaign->status->allowsProposals()
                || $campaign->proposals()->where('agency_id', $user->id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isCompany();
    }

    public function update(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin() || ($user->isCompany() && $campaign->company_id === $user->id);
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        return $this->update($user, $campaign) && $campaign->status !== CampaignStatus::Completed;
    }

    public function manageProposals(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin() || ($user->isCompany() && $campaign->company_id === $user->id);
    }

    public function updateStatus(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin() || ($user->isCompany() && $campaign->company_id === $user->id);
    }
}

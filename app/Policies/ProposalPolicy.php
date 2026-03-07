<?php

namespace App\Policies;

use App\Enums\ProposalStatus;
use App\Models\Proposal;
use App\Models\User;

class ProposalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isAgency() || $user->isCompany();
    }

    public function view(User $user, Proposal $proposal): bool
    {
        return $user->isAdmin()
            || $proposal->agency_id === $user->id
            || $proposal->campaign->company_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAgency();
    }

    public function update(User $user, Proposal $proposal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isAgency()
            && $proposal->agency_id === $user->id
            && $proposal->canBeUpdatedByAgency()
            && $proposal->campaign->allow_proposal_updates
            && ! $proposal->campaign->proposal_deadline->isPast();
    }

    public function delete(User $user, Proposal $proposal): bool
    {
        return $this->update($user, $proposal);
    }

    public function decide(User $user, Proposal $proposal): bool
    {
        return $user->isAdmin() || ($user->isCompany() && $proposal->campaign->company_id === $user->id);
    }

    public function withdraw(User $user, Proposal $proposal): bool
    {
        return $user->isAgency()
            && $proposal->agency_id === $user->id
            && in_array($proposal->status, [ProposalStatus::Submitted, ProposalStatus::Shortlisted], true);
    }
}

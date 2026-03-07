<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Review $review): bool
    {
        return $user->isAdmin() || $review->company_id === $user->id || $review->agency_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCompany();
    }

    public function update(User $user, Review $review): bool
    {
        return $user->isAdmin() || $review->company_id === $user->id;
    }

    public function delete(User $user, Review $review): bool
    {
        return $this->update($user, $review);
    }
}

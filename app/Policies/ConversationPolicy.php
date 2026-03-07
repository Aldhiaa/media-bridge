<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Conversation $conversation): bool
    {
        return $user->isAdmin()
            || $conversation->company_id === $user->id
            || $conversation->agency_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCompany() || $user->isAgency() || $user->isAdmin();
    }

    public function update(User $user, Conversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    public function delete(User $user, Conversation $conversation): bool
    {
        return $user->isAdmin();
    }
}

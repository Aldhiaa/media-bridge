<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Proposal;
use App\Models\Review;
use App\Models\User;
use App\Policies\CampaignPolicy;
use App\Policies\ConversationPolicy;
use App\Policies\ProposalPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', fn (User $user): bool => $user->isAdmin());
        Gate::policy(Campaign::class, CampaignPolicy::class);
        Gate::policy(Proposal::class, ProposalPolicy::class);
        Gate::policy(Conversation::class, ConversationPolicy::class);
        Gate::policy(Review::class, ReviewPolicy::class);

        View::composer('*', function ($view): void {
            if (! auth()->check()) {
                $view->with('navStats', [
                    'unread_notifications' => 0,
                    'unread_messages' => 0,
                ]);

                return;
            }

            /** @var \App\Models\User $user */
            $user = auth()->user();

            $view->with('navStats', [
                'unread_notifications' => $user->unreadNotifications()->count(),
                'unread_messages' => Message::query()->unreadFor($user)->count(),
            ]);
        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\CampaignStatus;
use App\Enums\ProposalStatus;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isCompany() && $user->companyProfile && ! $user->companyProfile->is_complete) {
            return redirect()->route('company.profile.edit')->with('success', 'Complete your company profile first.');
        }

        if ($user->isAgency() && $user->agencyProfile && ! $user->agencyProfile->is_complete) {
            return redirect()->route('agency.profile.edit')->with('success', 'Complete your agency profile first.');
        }

        return redirect()->route($user->dashboardRouteName());
    }

    public function company(Request $request): View
    {
        $user = $request->user();

        $totalCampaigns = Campaign::query()->where('company_id', $user->id)->count();
        $activeCampaigns = Campaign::query()
            ->where('company_id', $user->id)
            ->whereIn('status', [
                CampaignStatus::Published->value,
                CampaignStatus::ReceivingProposals->value,
                CampaignStatus::UnderReview->value,
                CampaignStatus::Awarded->value,
                CampaignStatus::InProgress->value,
            ])
            ->count();

        $proposalStats = Proposal::query()
            ->whereHas('campaign', fn ($query) => $query->where('company_id', $user->id))
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as accepted', [ProposalStatus::Accepted->value])
            ->first();

        $recentMessages = Conversation::query()
            ->with('messages.sender')
            ->where('company_id', $user->id)
            ->latest('last_message_at')
            ->take(5)
            ->get();

        $latestUpdates = Campaign::query()
            ->where('company_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('company.dashboard', [
            'totalCampaigns' => $totalCampaigns,
            'activeCampaigns' => $activeCampaigns,
            'proposalsReceived' => (int) ($proposalStats->total ?? 0),
            'acceptedProposals' => (int) ($proposalStats->accepted ?? 0),
            'recentMessages' => $recentMessages,
            'latestUpdates' => $latestUpdates,
        ]);
    }

    public function agency(Request $request): View
    {
        $user = $request->user();

        $totalProposals = Proposal::query()->where('agency_id', $user->id)->count();
        $shortlisted = Proposal::query()->where('agency_id', $user->id)->where('status', ProposalStatus::Shortlisted->value)->count();
        $accepted = Proposal::query()->where('agency_id', $user->id)->where('status', ProposalStatus::Accepted->value)->count();
        $activeProjects = Proposal::query()
            ->where('agency_id', $user->id)
            ->where('status', ProposalStatus::Accepted->value)
            ->whereHas('campaign', fn ($query) => $query->whereIn('status', [CampaignStatus::Awarded->value, CampaignStatus::InProgress->value]))
            ->count();

        $recentMessages = Conversation::query()
            ->with('messages.sender')
            ->where('agency_id', $user->id)
            ->latest('last_message_at')
            ->take(5)
            ->get();

        $latestMatchingCampaigns = Campaign::query()
            ->openForAgencies()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('agency.dashboard', compact(
            'totalProposals',
            'shortlisted',
            'accepted',
            'activeProjects',
            'recentMessages',
            'latestMatchingCampaigns',
        ));
    }
}

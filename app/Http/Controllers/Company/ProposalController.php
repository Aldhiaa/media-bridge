<?php

namespace App\Http\Controllers\Company;

use App\Enums\CampaignStatus;
use App\Enums\ProposalStatus;
use App\Http\Controllers\Controller;
use App\Models\AgencyProfile;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\Proposal;
use App\Notifications\ProposalStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function index(Request $request, Campaign $campaign): View
    {
        $this->authorize('manageProposals', $campaign);

        $sort = $request->string('sort', 'date')->toString();
        if (! in_array($sort, ['date', 'price', 'experience'], true)) {
            $sort = 'date';
        }

        $direction = strtolower($request->string('direction', 'desc')->toString()) === 'asc' ? 'asc' : 'desc';

        $query = $campaign->proposals()->with('agency.agencyProfile');

        if ($sort === 'price') {
            $query->orderBy('proposed_price', $direction);
        } elseif ($sort === 'experience') {
            $query->orderBy(
                AgencyProfile::select('years_experience')
                    ->whereColumn('agency_profiles.user_id', 'proposals.agency_id')
                    ->limit(1),
                $direction,
            );
        } else {
            $query->orderByRaw("COALESCE(submitted_at, created_at) {$direction}");
        }

        $proposals = $query->get();

        return view('company.proposals.index', compact('campaign', 'proposals', 'sort', 'direction'));
    }

    public function shortlist(Proposal $proposal): RedirectResponse
    {
        $this->authorize('decide', $proposal);

        if ($proposal->status === ProposalStatus::Accepted) {
            return back()->withErrors(['proposal' => 'Accepted proposals cannot be short-listed.']);
        }

        $proposal->update([
            'status' => ProposalStatus::Shortlisted->value,
            'shortlisted_at' => now(),
        ]);

        if (in_array($proposal->campaign->status, [CampaignStatus::Published, CampaignStatus::ReceivingProposals], true)) {
            $proposal->campaign->update(['status' => CampaignStatus::UnderReview->value]);
        }

        $proposal->agency->notify(new ProposalStatusNotification($proposal, $proposal->status->label()));

        return back()->with('success', 'Proposal short-listed successfully.');
    }

    public function reject(Proposal $proposal): RedirectResponse
    {
        $this->authorize('decide', $proposal);

        if ($proposal->status === ProposalStatus::Accepted) {
            return back()->withErrors(['proposal' => 'Accepted proposal cannot be rejected directly.']);
        }

        $proposal->update([
            'status' => ProposalStatus::Rejected->value,
            'rejected_at' => now(),
        ]);

        $proposal->agency->notify(new ProposalStatusNotification($proposal, $proposal->status->label()));

        return back()->with('success', 'Proposal rejected successfully.');
    }

    public function accept(Proposal $proposal): RedirectResponse
    {
        $this->authorize('decide', $proposal);

        $campaign = $proposal->campaign()->with('proposals.agency')->firstOrFail();

        $existingAccepted = $campaign->proposals->firstWhere('status', ProposalStatus::Accepted);
        if ($existingAccepted && $existingAccepted->id !== $proposal->id) {
            return back()->withErrors(['proposal' => 'This campaign already has an accepted proposal.']);
        }

        DB::transaction(function () use ($proposal, $campaign): void {
            $proposal->update([
                'status' => ProposalStatus::Accepted->value,
                'accepted_at' => now(),
            ]);

            $campaign->update([
                'status' => CampaignStatus::Awarded->value,
            ]);

            Proposal::query()
                ->where('campaign_id', $campaign->id)
                ->where('id', '!=', $proposal->id)
                ->where('status', '!=', ProposalStatus::Rejected->value)
                ->update([
                    'status' => ProposalStatus::Rejected->value,
                    'rejected_at' => now(),
                ]);

            Conversation::query()->firstOrCreate([
                'campaign_id' => $campaign->id,
                'proposal_id' => $proposal->id,
                'company_id' => $campaign->company_id,
                'agency_id' => $proposal->agency_id,
            ], [
                'last_message_at' => now(),
            ]);
        });

        Proposal::query()->where('campaign_id', $campaign->id)->with('agency')->get()->each(function (Proposal $campaignProposal): void {
            $campaignProposal->agency->notify(new ProposalStatusNotification($campaignProposal, $campaignProposal->status->label()));
        });

        return back()->with('success', 'Proposal accepted. Campaign awarded successfully.');
    }
}

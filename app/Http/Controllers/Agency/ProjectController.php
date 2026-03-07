<?php

namespace App\Http\Controllers\Agency;

use App\Enums\ProposalStatus;
use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Proposal::query()
            ->where('agency_id', $request->user()->id)
            ->where('status', ProposalStatus::Accepted->value)
            ->with(['campaign.category', 'campaign.company.companyProfile'])
            ->latest('accepted_at')
            ->paginate(10);

        return view('agency.projects.index', compact('projects'));
    }

    public function show(Request $request, Proposal $proposal): View
    {
        $this->authorize('view', $proposal);
        abort_unless($proposal->agency_id === $request->user()->id, 403);

        $proposal->load([
            'campaign.channels',
            'campaign.attachments',
            'campaign.company.companyProfile',
            'campaign.conversations' => fn ($query) => $query->where('agency_id', $request->user()->id),
        ]);

        $conversation = $proposal->campaign->conversations->first();

        return view('agency.projects.show', compact('proposal', 'conversation'));
    }
}

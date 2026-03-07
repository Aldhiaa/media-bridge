<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'campaign_id']);

        $proposals = Proposal::query()
            ->with(['campaign.company', 'agency.agencyProfile'])
            ->when($filters['status'] ?? null, fn ($query, $value) => $query->where('status', $value))
            ->when($filters['campaign_id'] ?? null, fn ($query, $value) => $query->where('campaign_id', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.proposals.index', compact('proposals', 'filters'));
    }

    public function show(Proposal $proposal): View
    {
        $proposal->load(['campaign.company.companyProfile', 'agency.agencyProfile', 'attachments']);

        return view('admin.proposals.show', compact('proposal'));
    }

    public function updateStatus(Request $request, Proposal $proposal): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:submitted,shortlisted,accepted,rejected,withdrawn'],
        ]);

        $proposal->update(['status' => $validated['status']]);

        return back()->with('success', 'Proposal status updated.');
    }
}

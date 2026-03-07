<?php

namespace App\Http\Controllers\Agency;

use App\Enums\ProposalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\Proposal;
use App\Notifications\ProposalSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function index(Request $request): View
    {
        $proposals = Proposal::query()
            ->where('agency_id', $request->user()->id)
            ->with(['campaign.company.companyProfile', 'attachments'])
            ->latest()
            ->paginate(12);

        return view('agency.proposals.index', compact('proposals'));
    }

    public function create(Request $request, Campaign $campaign): View
    {
        $this->authorize('create', Proposal::class);
        $this->authorize('view', $campaign);

        if (! $campaign->canReceiveProposals()) {
            abort(403, 'This campaign is not accepting proposals now.');
        }

        $existingProposal = Proposal::query()
            ->where('campaign_id', $campaign->id)
            ->where('agency_id', $request->user()->id)
            ->first();

        return view('agency.proposals.create', compact('campaign', 'existingProposal'));
    }

    public function store(StoreProposalRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize('create', Proposal::class);
        $this->authorize('view', $campaign);

        if (! $campaign->canReceiveProposals()) {
            return back()->withErrors(['proposal' => 'This campaign is closed for new proposals.']);
        }

        $validated = $request->validated();

        $proposal = DB::transaction(function () use ($request, $campaign, $validated): Proposal {
            $existing = Proposal::query()
                ->where('campaign_id', $campaign->id)
                ->where('agency_id', $request->user()->id)
                ->first();

            $payload = [
                'proposed_price' => $validated['proposed_price'],
                'strategy_summary' => strip_tags($validated['strategy_summary']),
                'execution_timeline' => strip_tags($validated['execution_timeline']),
                'relevant_experience' => strip_tags($validated['relevant_experience'] ?? ''),
                'notes' => strip_tags($validated['notes'] ?? ''),
            ];

            if ($existing) {
                if (! $campaign->allow_proposal_updates || $campaign->proposal_deadline->isPast() || ! $existing->canBeUpdatedByAgency()) {
                    abort(422, 'You cannot submit another active proposal to this campaign.');
                }

                $existing->update(array_merge($payload, [
                    'is_revision' => true,
                    'status' => ProposalStatus::Submitted->value,
                    'submitted_at' => now(),
                    'shortlisted_at' => null,
                ]));

                $proposal = $existing;
            } else {
                $proposal = Proposal::create(array_merge($payload, [
                    'campaign_id' => $campaign->id,
                    'agency_id' => $request->user()->id,
                    'status' => ProposalStatus::Submitted->value,
                    'submitted_at' => now(),
                ]));
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('proposals', 'public');
                    $proposal->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            Conversation::query()->firstOrCreate([
                'campaign_id' => $campaign->id,
                'company_id' => $campaign->company_id,
                'agency_id' => $request->user()->id,
            ], [
                'proposal_id' => $proposal->id,
                'last_message_at' => now(),
            ]);

            return $proposal;
        });

        $campaign->company->notify(new ProposalSubmittedNotification($proposal->load(['agency', 'campaign'])));

        return redirect()->route('agency.proposals.show', $proposal)->with('success', 'Proposal submitted successfully.');
    }

    public function show(Proposal $proposal): View
    {
        $this->authorize('view', $proposal);

        $proposal->load(['campaign.category', 'campaign.company.companyProfile', 'attachments']);

        return view('agency.proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal): View
    {
        $this->authorize('update', $proposal);
        $proposal->load('campaign');

        return view('agency.proposals.edit', compact('proposal'));
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal): RedirectResponse
    {
        $this->authorize('update', $proposal);
        $validated = $request->validated();

        DB::transaction(function () use ($request, $proposal, $validated): void {
            $proposal->update([
                'proposed_price' => $validated['proposed_price'],
                'strategy_summary' => strip_tags($validated['strategy_summary']),
                'execution_timeline' => strip_tags($validated['execution_timeline']),
                'relevant_experience' => strip_tags($validated['relevant_experience'] ?? ''),
                'notes' => strip_tags($validated['notes'] ?? ''),
                'is_revision' => true,
                'submitted_at' => now(),
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('proposals', 'public');
                    $proposal->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        });

        return redirect()->route('agency.proposals.show', $proposal)->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal): RedirectResponse
    {
        $this->authorize('withdraw', $proposal);

        $proposal->update(['status' => ProposalStatus::Withdrawn->value]);

        return redirect()->route('agency.proposals.index')->with('success', 'Proposal withdrawn successfully.');
    }
}

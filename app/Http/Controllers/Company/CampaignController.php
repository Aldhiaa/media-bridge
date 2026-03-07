<?php

namespace App\Http\Controllers\Company;

use App\Enums\CampaignStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Industry;
use App\Models\User;
use App\Notifications\CampaignStatusNotification;
use App\Notifications\NewCampaignNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'category_id', 'industry_id', 'status', 'budget_min', 'budget_max', 'deadline_before']);

        $campaigns = Campaign::query()
            ->where('company_id', $request->user()->id)
            ->with(['category', 'industry'])
            ->withCount('proposals')
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();

        return view('company.campaigns.index', compact('campaigns', 'filters', 'categories', 'industries'));
    }

    public function create(): View
    {
        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();
        $channels = config('marketplace.channels');

        return view('company.campaigns.create', compact('categories', 'industries', 'channels'));
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $campaign = DB::transaction(function () use ($request, $validated): Campaign {
            $payload = collect($validated)->except(['channels', 'attachments'])->all();
            $payload['status'] = $validated['status'] ?? CampaignStatus::Draft->value;
            $payload['published_at'] = in_array($payload['status'], [
                CampaignStatus::Published->value,
                CampaignStatus::ReceivingProposals->value,
            ], true) ? now() : null;
            $payload['description'] = strip_tags($payload['description']);
            $payload['target_audience'] = strip_tags($payload['target_audience']);
            $payload['required_deliverables'] = strip_tags($payload['required_deliverables']);

            /** @var Campaign $campaign */
            $campaign = $request->user()->companyCampaigns()->create($payload);

            foreach (array_unique($validated['channels']) as $channel) {
                $campaign->channels()->create(['channel' => $channel]);
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('campaigns', 'public');
                    $campaign->attachments()->create([
                        'uploaded_by' => $request->user()->id,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            return $campaign;
        });

        if (in_array($campaign->status, [CampaignStatus::Published, CampaignStatus::ReceivingProposals], true)) {
            $this->notifyAgenciesOfNewCampaign($campaign);
        }

        return redirect()->route('company.campaigns.show', $campaign)->with('success', 'Campaign created successfully.');
    }

    public function show(Request $request, Campaign $campaign): View
    {
        $this->authorize('view', $campaign);

        $sort = $request->string('sort', 'date')->toString();
        $direction = $request->string('direction', 'desc')->toString();

        $query = $campaign->proposals()->with('agency.agencyProfile');
        if ($sort === 'price') {
            $query->orderBy('proposed_price', $direction);
        } else {
            $query->latest();
        }

        $proposals = $query->get();
        if ($sort === 'experience') {
            $proposals = $proposals->sortByDesc(fn ($proposal) => $proposal->agency?->agencyProfile?->years_experience ?? 0);
        }

        $campaign->load(['category', 'industry', 'channels', 'attachments', 'acceptedProposal.agency']);

        return view('company.campaigns.show', compact('campaign', 'proposals', 'sort', 'direction'));
    }

    public function edit(Campaign $campaign): View
    {
        $this->authorize('update', $campaign);

        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();
        $channels = config('marketplace.channels');

        $campaign->load('channels');

        return view('company.campaigns.edit', compact('campaign', 'categories', 'industries', 'channels'));
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize('update', $campaign);
        $validated = $request->validated();

        DB::transaction(function () use ($request, $campaign, $validated): void {
            $payload = collect($validated)->except(['channels', 'attachments'])->all();
            $payload['description'] = strip_tags($payload['description']);
            $payload['target_audience'] = strip_tags($payload['target_audience']);
            $payload['required_deliverables'] = strip_tags($payload['required_deliverables']);

            if (($payload['status'] ?? null) && $campaign->published_at === null && in_array($payload['status'], [
                CampaignStatus::Published->value,
                CampaignStatus::ReceivingProposals->value,
            ], true)) {
                $payload['published_at'] = now();
            }

            $campaign->update($payload);

            $campaign->channels()->delete();
            foreach (array_unique($validated['channels']) as $channel) {
                $campaign->channels()->create(['channel' => $channel]);
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('campaigns', 'public');
                    $campaign->attachments()->create([
                        'uploaded_by' => $request->user()->id,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        });

        return redirect()->route('company.campaigns.show', $campaign)->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $this->authorize('delete', $campaign);
        $campaign->update(['status' => CampaignStatus::Cancelled->value]);

        return redirect()->route('company.campaigns.index')->with('success', 'Campaign cancelled successfully.');
    }

    public function updateStatus(Request $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize('updateStatus', $campaign);

        $validated = $request->validate([
            'status' => ['required', 'in:under_review,awarded,in_progress,completed,cancelled,receiving_proposals'],
        ]);

        $campaign->update(['status' => $validated['status']]);

        $acceptedProposal = $campaign->acceptedProposal()->with('agency')->first();
        if ($acceptedProposal?->agency) {
            $acceptedProposal->agency->notify(new CampaignStatusNotification($campaign, $campaign->status->label()));
        }

        return back()->with('success', 'Campaign status updated successfully.');
    }

    private function notifyAgenciesOfNewCampaign(Campaign $campaign): void
    {
        User::query()
            ->where('role', 'agency')
            ->where('status', 'active')
            ->whereHas('agencyProfile', fn ($query) => $query->where('is_complete', true))
            ->chunkById(100, function ($users) use ($campaign): void {
                foreach ($users as $user) {
                    $user->notify(new NewCampaignNotification($campaign));
                }
            });
    }
}

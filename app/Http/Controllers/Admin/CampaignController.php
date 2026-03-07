<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'status', 'category_id']);

        $campaigns = Campaign::query()
            ->with(['company', 'category', 'industry'])
            ->when($filters['q'] ?? null, function ($query, $value): void {
                $query->where('title', 'like', "%{$value}%");
            })
            ->when($filters['status'] ?? null, fn ($query, $value) => $query->where('status', $value))
            ->when($filters['category_id'] ?? null, fn ($query, $value) => $query->where('category_id', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.campaigns.index', compact('campaigns', 'filters'));
    }

    public function show(Campaign $campaign): View
    {
        $campaign->load(['company.companyProfile', 'category', 'industry', 'proposals.agency', 'attachments', 'channels']);

        return view('admin.campaigns.show', compact('campaign'));
    }

    public function updateStatus(Request $request, Campaign $campaign): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,published,receiving_proposals,under_review,awarded,in_progress,completed,cancelled'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $campaign->update([
            'status' => $validated['status'],
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
        ]);

        return back()->with('success', 'Campaign moderation updated.');
    }
}

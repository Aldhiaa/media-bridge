<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'category_id', 'industry_id', 'budget_min', 'budget_max', 'deadline_before']);

        $favoriteIds = $request->user()->favoriteCampaigns()->pluck('campaign_id')->map(fn ($id) => (int) $id)->all();

        $campaigns = Campaign::query()
            ->openForAgencies()
            ->with(['company.companyProfile', 'category', 'industry'])
            ->filter($filters)
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();

        return view('agency.campaigns.index', compact('campaigns', 'filters', 'categories', 'industries', 'favoriteIds'));
    }

    public function show(Request $request, Campaign $campaign): View
    {
        $this->authorize('view', $campaign);

        $campaign->load(['company.companyProfile', 'category', 'industry', 'channels', 'attachments']);
        $myProposal = $campaign->proposals()->where('agency_id', $request->user()->id)->first();
        $isFavorited = $request->user()->favoriteCampaigns()->where('campaign_id', $campaign->id)->exists();

        return view('agency.campaigns.show', compact('campaign', 'myProposal', 'isFavorited'));
    }

    public function favorite(Request $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize('view', $campaign);
        $request->user()->favoriteCampaigns()->syncWithoutDetaching([$campaign->id]);

        return back()->with('success', 'Campaign saved to favorites.');
    }

    public function unfavorite(Request $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize('view', $campaign);
        $request->user()->favoriteCampaigns()->detach($campaign->id);

        return back()->with('success', 'Campaign removed from favorites.');
    }

    public function favorites(Request $request): View
    {
        $campaigns = $request->user()
            ->favoriteCampaigns()
            ->with(['company.companyProfile', 'category', 'industry'])
            ->latest('campaign_favorites.created_at')
            ->paginate(12);

        return view('agency.campaigns.favorites', compact('campaigns'));
    }
}

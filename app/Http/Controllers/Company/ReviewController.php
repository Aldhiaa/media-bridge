<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Campaign;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = Review::query()
            ->where('company_id', $request->user()->id)
            ->with(['campaign', 'agency.agencyProfile'])
            ->latest()
            ->paginate(10);

        return view('company.reviews.index', compact('reviews'));
    }

    public function store(StoreReviewRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize('create', Review::class);

        if ($campaign->company_id !== $request->user()->id) {
            abort(403);
        }

        if (! $campaign->status->canReceiveReview()) {
            return back()->withErrors(['review' => 'Reviews are allowed only after campaign completion.']);
        }

        $acceptedProposal = $campaign->acceptedProposal;
        if (! $acceptedProposal) {
            return back()->withErrors(['review' => 'No accepted proposal found for this campaign.']);
        }

        $existingReview = Review::query()
            ->where('campaign_id', $campaign->id)
            ->where('company_id', $request->user()->id)
            ->exists();

        if ($existingReview) {
            return back()->withErrors(['review' => 'You have already reviewed this campaign.']);
        }

        Review::create([
            'campaign_id' => $campaign->id,
            'proposal_id' => $acceptedProposal->id,
            'company_id' => $request->user()->id,
            'agency_id' => $acceptedProposal->agency_id,
            'rating' => $request->validated('rating'),
            'comment' => strip_tags($request->validated('comment', '')),
            'is_approved' => false,
        ]);

        return back()->with('success', 'Review submitted and pending admin moderation.');
    }
}

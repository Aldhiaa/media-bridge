<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreReportRequest;
use App\Models\AgencyProfile;
use App\Models\Campaign;
use App\Models\Industry;
use App\Models\Report;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PublicController extends Controller
{
    public function home(): View
    {
        $featuredCampaigns = Campaign::query()
            ->with(['category', 'industry', 'company.companyProfile'])
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $featuredAgencies = AgencyProfile::query()
            ->with(['user', 'services', 'industries'])
            ->where('is_complete', true)
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'companies' => User::query()->where('role', Role::Company->value)->count(),
            'agencies' => User::query()->where('role', Role::Agency->value)->count(),
            'campaigns' => Campaign::query()->count(),
        ];

        return view('public.home', compact('featuredCampaigns', 'featuredAgencies', 'stats'));
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function howItWorks(): View
    {
        return view('public.how-it-works');
    }

    public function features(): View
    {
        return view('public.features');
    }

    public function pricing(): View
    {
        return view('public.pricing');
    }

    public function faq(): View
    {
        return view('public.faq');
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        if ($request->user()) {
            Report::create([
                'reporter_id' => $request->user()->id,
                'type' => 'other',
                'subject' => 'رسالة دعم من: '.$validated['name'],
                'details' => $validated['message'],
                'status' => 'open',
            ]);
        }

        return back()->with('success', 'Your message has been received. We will reply soon.');
    }

    public function storeReport(StoreReportRequest $request): RedirectResponse
    {
        Report::create([
            'reporter_id' => $request->user()->id,
            'reported_user_id' => $request->validated('reported_user_id'),
            'campaign_id' => $request->validated('campaign_id'),
            'proposal_id' => $request->validated('proposal_id'),
            'type' => $request->validated('type'),
            'subject' => $request->validated('subject'),
            'details' => strip_tags($request->validated('details')),
            'status' => 'open',
        ]);

        return back()->with('success', 'Report submitted successfully.');
    }

    public function agencies(Request $request): View
    {
        $filters = $request->only(['q', 'service_id', 'industry_id', 'city']);

        $agencies = AgencyProfile::query()
            ->with(['user', 'services', 'industries'])
            ->where('is_complete', true)
            ->when($filters['q'] ?? null, function ($query, $value): void {
                $query->where(function ($inner) use ($value): void {
                    $inner->where('agency_name', 'like', "%{$value}%")
                        ->orWhere('about', 'like', "%{$value}%");
                });
            })
            ->when($filters['service_id'] ?? null, fn ($query, $value) => $query->whereHas('services', fn ($q) => $q->where('services.id', $value)))
            ->when($filters['industry_id'] ?? null, fn ($query, $value) => $query->whereHas('industries', fn ($q) => $q->where('industries.id', $value)))
            ->when($filters['city'] ?? null, fn ($query, $value) => $query->where('city', 'like', "%{$value}%"))
            ->paginate(12)
            ->withQueryString();

        $services = Service::query()->where('is_active', true)->orderBy('name')->get();
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();

        return view('public.agencies', compact('agencies', 'services', 'industries', 'filters'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Message;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totals = [
            'users' => User::query()->count(),
            'companies' => User::query()->where('role', Role::Company->value)->count(),
            'agencies' => User::query()->where('role', Role::Agency->value)->count(),
            'campaigns' => Campaign::query()->count(),
            'proposals' => Proposal::query()->count(),
        ];

        $mostActiveUsers = User::query()
            ->withCount([
                'companyCampaigns as campaigns_count',
                'agencyProposals as proposals_count',
            ])
            ->orderByRaw('(campaigns_count + proposals_count) DESC')
            ->take(8)
            ->get();

        $latestReports = Report::query()->with('reporter')->latest()->take(8)->get();

        $recentActivity = collect()
            ->merge(Campaign::query()->latest()->take(5)->get()->map(fn (Campaign $item) => [
                'type' => 'campaign',
                'label' => 'New campaign: '.$item->title,
                'date' => $item->created_at,
            ]))
            ->merge(Proposal::query()->latest()->take(5)->get()->map(fn (Proposal $item) => [
                'type' => 'proposal',
                'label' => 'New proposal #'.$item->id,
                'date' => $item->created_at,
            ]))
            ->merge(Message::query()->latest()->take(5)->get()->map(fn (Message $item) => [
                'type' => 'message',
                'label' => 'New message #'.$item->id,
                'date' => $item->created_at,
            ]))
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return view('admin.dashboard', compact('totals', 'mostActiveUsers', 'latestReports', 'recentActivity'));
    }
}

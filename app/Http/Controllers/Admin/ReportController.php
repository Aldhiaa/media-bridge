<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $reports = Report::query()
            ->with(['reporter', 'reportedUser', 'campaign', 'proposal', 'resolver'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reports.index', compact('reports', 'status'));
    }

    public function updateStatus(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,under_review,resolved,dismissed'],
        ]);

        $report->update([
            'status' => $validated['status'],
            'resolved_by' => in_array($validated['status'], ['resolved', 'dismissed'], true) ? $request->user()->id : null,
            'resolved_at' => in_array($validated['status'], ['resolved', 'dismissed'], true) ? now() : null,
        ]);

        return back()->with('success', 'Report status updated.');
    }
}

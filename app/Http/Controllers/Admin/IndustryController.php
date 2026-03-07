<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndustryController extends Controller
{
    public function index(): View
    {
        $industries = Industry::query()->latest()->paginate(15);

        return view('admin.industries.index', compact('industries'));
    }

    public function create(): View
    {
        return view('admin.industries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:industries,name'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Industry::create($validated);

        return redirect()->route('admin.industries.index')->with('success', 'Industry created.');
    }

    public function show(Industry $industry): View
    {
        return view('admin.industries.show', compact('industry'));
    }

    public function edit(Industry $industry): View
    {
        return view('admin.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:industries,name,'.$industry->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $industry->update($validated);

        return redirect()->route('admin.industries.index')->with('success', 'Industry updated.');
    }

    public function destroy(Industry $industry): RedirectResponse
    {
        $industry->delete();

        return back()->with('success', 'Industry deleted.');
    }
}

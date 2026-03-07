<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()->latest()->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:services,name'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function show(Service $service): View
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:services,name,'.$service->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('success', 'Service deleted.');
    }
}

<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAgencyProfileRequest;
use App\Models\Industry;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = $request->user()->agencyProfile()->firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'agency_name' => $request->user()->name,
                'contact_person' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->user()->phone ?? 'N/A',
            ]
        );

        $services = Service::query()->where('is_active', true)->orderBy('name')->get();
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();

        $profile->load(['services', 'industries']);

        return view('agency.profile.edit', compact('profile', 'services', 'industries'));
    }

    public function update(UpdateAgencyProfileRequest $request): RedirectResponse
    {
        $profile = $request->user()->agencyProfile;
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos/agencies', 'public');
        }

        $serviceIds = $validated['service_ids'] ?? [];
        $industryIds = $validated['industry_ids'] ?? [];

        unset($validated['logo'], $validated['service_ids'], $validated['industry_ids']);

        $validated['about'] = isset($validated['about']) ? strip_tags($validated['about']) : null;
        $validated['is_complete'] = ! empty($validated['agency_name']) && ! empty($validated['phone']) && ! empty($serviceIds);

        $profile->update($validated);
        $profile->services()->sync($serviceIds);
        $profile->industries()->sync($industryIds);

        $request->user()->update([
            'name' => $validated['contact_person'],
            'phone' => $validated['phone'],
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
        ]);

        return redirect()->route('agency.profile.edit')->with('success', 'Agency profile updated successfully.');
    }
}

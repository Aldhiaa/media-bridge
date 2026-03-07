<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = $request->user()->companyProfile()->firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'company_name' => $request->user()->name,
                'contact_person' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->user()->phone ?? 'N/A',
            ]
        );

        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get();

        return view('company.profile.edit', compact('profile', 'industries'));
    }

    public function update(UpdateCompanyProfileRequest $request): RedirectResponse
    {
        $profile = $request->user()->companyProfile;
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos/companies', 'public');
        }

        unset($validated['logo']);

        $validated['is_complete'] = ! empty($validated['company_name'])
            && ! empty($validated['contact_person'])
            && ! empty($validated['phone']);

        $profile->update($validated);

        $request->user()->update([
            'name' => $validated['contact_person'],
            'phone' => $validated['phone'],
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
        ]);

        return redirect()->route('company.profile.edit')->with('success', 'تم تحديث ملف الشركة.');
    }
}

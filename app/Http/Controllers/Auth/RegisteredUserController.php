<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\AgencyProfile;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'roles' => [Role::Company, Role::Agency],
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:company,agency'],
            'phone' => ['required', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($user->isCompany()) {
            CompanyProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->name,
                'contact_person' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        } else {
            AgencyProfile::create([
                'user_id' => $user->id,
                'agency_name' => $request->name,
                'contact_person' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard.redirect');
    }
}

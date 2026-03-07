<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserStatusRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'role', 'status']);

        $users = User::query()
            ->with(['companyProfile', 'agencyProfile'])
            ->when($filters['q'] ?? null, function ($query, $value): void {
                $query->where(function ($inner) use ($value): void {
                    $inner->where('name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                });
            })
            ->when($filters['role'] ?? null, fn ($query, $value) => $query->where('role', $value))
            ->when($filters['status'] ?? null, fn ($query, $value) => $query->where('status', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'filters'));
    }

    public function edit(User $user): View
    {
        $user->load(['companyProfile', 'agencyProfile']);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserStatusRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $user->update(collect($data)->except('is_verified')->all());

        if ($user->isAgency() && $user->agencyProfile) {
            $user->agencyProfile->update([
                'is_verified' => (bool) ($data['is_verified'] ?? false),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
}

<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        if ($user->status !== UserStatus::Active) {
            abort(403, 'تم تعليق الحساب أو لا يزال قيد المراجعة.');
        }

        if (! empty($roles) && ! in_array($user->role->value, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}

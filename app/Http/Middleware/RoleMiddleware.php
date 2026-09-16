<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        // Make sure the user is logged in.
        if (! $request->user()) {
            abort(403, 'You must be logged in to access this page.');
        }

        // Check if the user's role is allowed.
        if (! in_array($request->user()->role, $roles, true)) {
            abort(
                403,
                'You do not have permission to perform this action.'
            );
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

/**
 * Class EnsureAdminIdentity
 *
 * Ensures that the authenticated entity resolving through Sanctum is strictly an instance of Admin.
 * Prevents cross-boundary access from valid User tokens on admin endpoints.
 *
 * @package App\Http\Middleware
 */
class EnsureAdminIdentity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !($user instanceof Admin)) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: Admin access required',
                'errors'  => null,
            ], 403);
        }

        auth()->setUser($user);

        return $next($request);
    }
}

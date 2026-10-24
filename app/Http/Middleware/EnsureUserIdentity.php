<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

/**
 * Class EnsureUserIdentity
 *
 * Ensures that the authenticated entity resolving through Sanctum is strictly an instance of User (Student).
 * Prevents cross-boundary access from valid Admin tokens on student endpoints.
 *
 * @package App\Http\Middleware
 */
class EnsureUserIdentity
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

        if (!$user || !($user instanceof User)) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: User access required',
                'errors'  => null,
            ], 403);
        }

        return $next($request);
    }
}

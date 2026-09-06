<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = $request->attributes->get('apiUser');

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        // Check if user has a plan (either paid or free)
        if (!$user->plan_id) {
            return response()->json([
                'message' => 'No active plan. Please subscribe to continue.',
            ], 403);
        }

        return $next($request);
    }
}

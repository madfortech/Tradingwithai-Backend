<?php

namespace App\Http\Middleware;

use App\Services\UniqueKeyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    public function __construct(
        private UniqueKeyService $uniqueKeyService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $plainKey = $request->bearerToken();

        if (!$plainKey) {
            return response()->json([
                'message' => 'API key is required.',
            ], 401);
        }

        $key = $this->uniqueKeyService->validate($plainKey);

        if (!$key) {
            return response()->json([
                'message' => 'Invalid API key.',
            ], 401);
        }

        // Update last used timestamp
        $this->uniqueKeyService->markAsUsed($key);

        // Make user available to next middleware/controllers
        $request->attributes->set('apiUser', $key->user);

        return $next($request);
    }
}

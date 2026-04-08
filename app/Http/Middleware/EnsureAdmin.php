<?php

namespace App\Http\Middleware;

use App\Support\JsonRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            if (JsonRequest::wantsJson($request)) {
                return response()->json([
                    'status' => 403,
                    'message' => 'Forbidden.',
                    'error' => 'Admin access only.',
                ], 403);
            }

            return redirect()
                ->route('home')
                ->with('error', 'Admin access only.');
        }

        return $next($request);
    }
}

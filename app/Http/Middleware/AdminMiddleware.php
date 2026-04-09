<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! ($user instanceof \App\Models\Admin)) {
            return ApiResponse::error('Unauthorized. Admin access required.', null, 401);
        }

        return $next($request);
    }
}

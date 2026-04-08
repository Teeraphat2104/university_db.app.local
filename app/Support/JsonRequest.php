<?php

namespace App\Support;

use Illuminate\Http\Request;

class JsonRequest
{
    public static function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }
}

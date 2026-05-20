<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

function setting(string $key, mixed $default = null): mixed
{
    try {
        return Setting::get($key, $default);
    } catch (\Exception $e) {
        return $default;
    }
}

function allSettings(): array
{
    try {
        return Setting::allGrouped();
    } catch (\Exception $e) {
        return [];
    }
}

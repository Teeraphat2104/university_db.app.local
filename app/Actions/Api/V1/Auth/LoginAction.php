<?php

namespace App\Actions\Api\V1\Auth;

use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $validated = validator($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ])->validate();

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (! Auth::guard('web')->attempt($credentials, (bool) ($validated['remember'] ?? false))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /** @var \App\Models\User|null $user */
        $user = Auth::guard('web')->user();

        if (! $user || ! $user->isAdmin()) {
            Auth::guard('web')->logout();

            throw ValidationException::withMessages([
                'email' => ['This account is not authorized for admin access.'],
            ]);
        }

        $request->session()->regenerate();

        return $this->successResponse($user->toArray(), 'Admin login successful.');
    }
}

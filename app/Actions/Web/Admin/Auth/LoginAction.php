<?php

namespace App\Actions\Web\Admin\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function __invoke(Request $request): RedirectResponse
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

        return redirect()
            ->intended(route('admin.dashboard'))
            ->with('success', 'Signed in successfully.');
    }
}

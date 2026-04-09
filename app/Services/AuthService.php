<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(string $email, string $password): array|false
    {
        $admin = Admin::where('email', $email)->first();

        if (! $admin || ! Hash::check($password, $admin->password)) {
            return false;
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return [
            'admin' => [
                'id'    => $admin->id,
                'name'  => $admin->name,
                'email' => $admin->email,
            ],
            'token' => $token,
        ];
    }

    public function logout($admin): void
    {
        $admin->currentAccessToken()->delete();
    }
}

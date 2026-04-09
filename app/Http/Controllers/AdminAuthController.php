<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    /**
     * POST /api/admin/login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return ApiResponse::error('Invalid email or password.', null, 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return ApiResponse::success('Login successful', [
            'admin' => [
                'id'    => $admin->id,
                'name'  => $admin->name,
                'email' => $admin->email,
            ],
            'token' => $token,
        ]);
    }

    /**
     * GET /api/admin/profile
     */
    public function profile(Request $request)
    {
        $admin = $request->user();

        return ApiResponse::success('Profile fetched successfully', [
            'id'    => $admin->id,
            'name'  => $admin->name,
            'email' => $admin->email,
        ]);
    }

    /**
     * POST /api/admin/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success('Logout successful');
    }
}

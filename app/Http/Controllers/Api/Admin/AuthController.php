<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    /**
     * POST /api/admin/login
     */
    public function login(AdminLoginRequest $request)
    {
        $result = $this->authService->login(
            $request->email,
            $request->password
        );

        if (! $result) {
            return ApiResponse::error('Invalid email or password.', null, 401);
        }

        return ApiResponse::success('Login successful', $result);
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
        $this->authService->logout($request->user());

        return ApiResponse::success('Logout successful');
    }
}

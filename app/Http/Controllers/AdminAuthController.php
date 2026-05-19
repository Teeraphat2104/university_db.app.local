<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $response = (object)[];

        try {
            $data = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $admin = Admin::where('email', $data['email'])->first();

            if (! $admin || ! Hash::check($data['password'], $admin->password)) {
                $response->success = false;
                $response->message = 'Invalid email or password.';
                $response->errors = null;
                return response()->json($response, 401);
            }

            $token = $admin->createToken('admin-token')->plainTextToken;

            $response->success = true;
            $response->message = 'Login successful';
            $response->data = [
                'admin' => [
                    'id'    => $admin->id,
                    'name'  => $admin->name,
                    'email' => $admin->email,
                ],
                'token' => $token,
            ];

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'Validation failed';
            $response->errors = $e->getMessage();
            $httpCode = 422;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function profile(Request $request)
    {
        $response = (object)[];

        try {
            $admin = $request->user();

            $response->success = true;
            $response->message = 'Profile fetched successfully';
            $response->data = [
                'id'    => $admin->id,
                'name'  => $admin->name,
                'email' => $admin->email,
            ];

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function logout(Request $request)
    {
        $response = (object)[];

        try {
            $request->user()->currentAccessToken()->delete();

            $response->success = true;
            $response->message = 'Logout successful';

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }
}

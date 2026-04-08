<?php

namespace App\Actions\Web\Admin\Auth;

use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutAction
{
    use ApiResponse;

    public function __invoke(Request $request): RedirectResponse|JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'redirect_url' => route('admin.login'),
            ], 'Signed out successfully.');
        }

        return redirect()
            ->route('admin.login')
            ->with('success', 'Signed out successfully.');
    }
}

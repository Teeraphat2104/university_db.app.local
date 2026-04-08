<?php

namespace App\Actions\Web\Admin\Auth;

use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowLoginAction
{
    use ApiResponse;

    public function __invoke(Request $request): View|JsonResponse
    {
        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'form' => [
                    'action' => route('admin.login.store'),
                    'method' => 'POST',
                ],
            ], 'Login form data fetched successfully.');
        }

        return view('admin.auth.login');
    }
}

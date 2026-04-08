<?php

namespace App\Http\Controllers\Web\Admin;

use App\Actions\Web\Admin\Auth\LoginAction as AdminLoginAction;
use App\Actions\Web\Admin\Auth\LogoutAction as AdminLogoutAction;
use App\Actions\Web\Admin\Auth\ShowLoginAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return (new ShowLoginAction())($request);
    }

    public function login(Request $request)
    {
        return (new AdminLoginAction())($request);
    }

    public function logout(Request $request)
    {
        return (new AdminLogoutAction())($request);
    }
}
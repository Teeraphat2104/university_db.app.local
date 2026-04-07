<?php

namespace App\Actions\Web\Admin\Auth;

use Illuminate\Contracts\View\View;

class ShowLoginAction
{
    public function __invoke(): View
    {
        return view('admin.auth.login');
    }
}

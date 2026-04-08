<?php

namespace App\Http\Controllers\Web\Admin;

use App\Actions\Web\Admin\Dashboard\IndexAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return (new IndexAction())($request);
    }
}
<?php

namespace App\Http\Controllers\Web;

use App\Actions\Web\Public\HomeAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return (new HomeAction())($request);
    }
}
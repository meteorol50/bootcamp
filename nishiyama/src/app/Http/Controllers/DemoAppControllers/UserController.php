<?php

namespace App\Http\Controllers\DemoAppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('DemoAppViews/registration');
    }

    public function input_code(Request $request)
    {
        return view('DemoAppViews/authentication');
    }

    public function complete()
    {
        return view('DemoAppViews/completion');
    }
}

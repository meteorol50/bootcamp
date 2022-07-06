<?php

namespace App\Http\Controllers\DemoAppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemoAppModels\EmailAuthentication;

class EmailAuthenticationController extends Controller
{
    public function create()
    {
        return view('DemoAppViews/registration');
    }

    public function store (Request $request)
    {
        $email_authentication = EmailAuthentication::create();

        $email_authentication->authentication_code = str_pad(random_int(0, 999999), 6, 0, STR_PAD_LEFT);
        $email_authentication->email = $request->email;

        $email_authentication->save();

        return redirect()
            ->route('/');
    }
}

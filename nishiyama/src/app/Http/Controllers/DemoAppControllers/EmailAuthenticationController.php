<?php

namespace App\Http\Controllers\DemoAppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\DemoAppModels\EmailAuthentication;
use App\Mail\AuthMail;

class EmailAuthenticationController extends Controller
{
    public function store(Request $request)
    {
        $email_authentication = new EmailAuthentication();

        $email_authentication->authentication_code = str_pad(random_int(0, 999999), 6, 0, STR_PAD_LEFT);
        $email_authentication->email = $request->email;

        $email_authentication->save();

        Mail::to($email_authentication->email)
            ->send(new AuthMail($email_authentication->email, $email_authentication->authentication_code));

        return redirect()
            ->route('email_authentications.input_code');
    }

    public function authenticate(Request $request)
    {
        $email_authentication = EmailAuthentication::where('email', $request->email)->first();

        if ($email_authentication->authentication_code === $request->auth_code) {
            $email_authentication->delete();
            return redirect()
                ->route('email_authentications.complete');
        } else {
            return redirect()
                ->route('email_authentications.input_code');
        }
    }
}

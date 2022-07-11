<?php

namespace App\Http\Controllers\DemoAppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemoAppModels\User;

class UserController extends Controller
{
    public function create()
    {
        return view('DemoAppViews/registration');
    }

    // 会員登録API
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = encrypt($request->password);
        $user->auth_flag = false;

        $user->save();

        // ここで、入力されたメールアドレスに認証コードを送信
        $email_authentication_controller= app()->make('App\Http\Controllers\DemoAppControllers\EmailAuthenticationController');
        $email_authentication_controller->sendAuthCode($request);

        return redirect()
            ->route('email_authentications.inputCode');
    }

    public function inputCode()
    {
        return view('DemoAppViews/authentication');
    }

    public function complete()
    {
        return view('DemoAppViews/completion');
    }
}

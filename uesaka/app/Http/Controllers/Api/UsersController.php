<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\TokenService;
use App\Models\Api\User;
use DateTime;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function authToken(Request $request)
    {
        $token = $request->token;

        //6~8. トークン検索からチェックまでを行う
        $tokenService = new TokenService;
        $authResult = $tokenService->matchToken($token);

        if( $authResult == "OK"){
            $data = User::where([
                'email' => $tokenService->getMail($token)
            ])->first();

            $now = new DateTime();

            $data->auth_flag = true;
            $data->email_verified_at = $now;
            $data->remember_token = $token;
            $data->update();

            //10. ログイン状態にしてユーザトップページへリダイレクト
            $request->session()->put('logind', 'true');
            //$request->session()->put('id', $id);
            return redirect('/user/login');

        }else if($authResult == "ALREADY"){
        //10. エラーメッセージとともにトップページへリダイレクト
        return redirect('user/login')->with('message', 'このメールアドレスはすでに認証されています。');
        }
    }

    public function getData(Request $request)
    {
        $data = User::where([
            'email' => session()->get('email')
        ])->first();
        return ([
            'NAME' => $data->name,
            'MAIL' => $data->email,
            'PASS' => $data->password,
        ]);

    }
}

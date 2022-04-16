<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserService;
use App\Models\Api\User;
use App\Http\Controllers\Api\TokenService;
use Mail;
use App\Mail\AuthMail;

class mailverify extends Controller
{
    public function create(Request $request)
    {
        //3. ユーザデータを保存
        //var_dump($request->email);
        $userService = new User();
        $userService->create([
            'name' => $request->name,
            'email' => $request->email,
            'auth_flag' => false,
            'password' => $request->password
        ]);

        //2. トークンを発行
        $tokenService = new TokenService();
        $tokenService->create($request);

        //4. メールを送信
        $email = $request->email;
        //メールに記載する認証用URlを組み立てている(認証用ページURL+トークン)。
        $url = request()->getSchemeAndHttpHost(). "/user/register/?token=".$tokenService->getToken();

        $mailContent = new AuthMail($url);
        //var_dump($mailContent->build());
        //$now = new DateTime();
        Mail::to($email)
                ->send($mailContent->build());

        //メール送信完了画面へリダイレクト
        return view('welcome');//redirect('/join')->with('email',$email);
}
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Api\User;
use App\Models\Api\Token;
use App\Http\Controllers\Api\TokenService;
use App\Models\Api\password_reset;
use App\Http\Controllers\Controller;
use Mail;
use DateTime;
use App\Mail\AuthMail;

class passwordController extends Controller
{
    //
    public function resetUrl(Request $request)
    {
        $data = User::where([
            'email' => $request->email
        ])->first();
        //
        if ($data->name === $request->name)
        {
            //$tokenService = new TokenService();
            $token = uniqid('', true);

            $newPass = new password_reset();
            $newPass->create
            ([
                'email' => $request->email,
                'token' => $token,
                'password' => $request->password,
            ]);

            //4. メールを送信
            $email = $request->email;
            //メールに記載する認証用URlを組み立てている(認証用ページURL+トークン)。
            $url = request()->getSchemeAndHttpHost(). "/user/resetP/?token=".$token;

            $mailContent = new AuthMail($url);
            //var_dump($mailContent->build());
            //$now = new DateTime();
            Mail::to($email)
                    ->send($mailContent->build());

            //メール送信完了画面へリダイレクト
            return redirect('/');
        }else{
            return ['message' => 'invalid name or mail!'];
        }
        //
    }

    public function authUrl(Request $request)
    {
        $token = $request->token;

        //$newPass = new password_reset();

        $data = password_reset::where([
            'token' => $token
        ])->first();
        $email = $data->email;
        $password = $data->password;

        //8. トークンチェック
        if(is_null($data)){
            //DBから値が返ってこないのでトークンが間違っている、チェックNG
            return "WRONG";
        }else if($data->auth_flag){
            //検索して見つかったトークンデータの認証フラグが既に立っている(=認証済み)、チェックNG
            return "ALREADY";
        }

        $now = new DateTime();
        $expire_date = new DateTime($data->expire_at);

        //9. 認証処理(有効なトークンだった場合はフラグを認証済み(true)に更新)
        if($now < $expire_date){
            $data = User::where([
                'email' => $email
            ])->first();
            $data->password = $password;
            $data->update();

            return redirect('/')->with('message', 'OK');
        }else{
            //有効期限が切れている、チェックNG
            //有効期限の切れたトークンデータ、ユーザデータはもう二度と認証できないので削除
            $email = $data->email;
            Token::where([
                'token' => $token
            ])->delete();
            $userService = new User();
            $userService->deleteByEmail($email);
            return "EXPIRE";
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use DateTime;
use App\Models\Api\Token;

class TokenService
{
    private $token = '';

    public function create(Request $request)
    {
        $email = $request->email;
        $now = new DateTime();
        $now->format("Y-m-d H:i:s");
        //有効期限を計算(30分とした)
        $expire_at = $now->modify('+30 minutes');

        $token = new Token();
        // //トークンを生成
        $this->token = uniqid('', true);
        //3. トークンをDBに保存
        $token->create([
            'name' => $request->name,
            'token' => $this->token,
            'auth_flag' => false,
            'email' => $email,
            'expire_at' => $expire_at
        ]);
    }
    public function getToken()
    {
        return $this->token;
    }

    public function getMail($token)
    {
        $data = Token::where([
            'token' => $token
        ])->first();
        return $data->email;
    }

    public function matchToken($token)
    {
        $now = new DateTime();

        //6. ユーザから送信されたトークンを検索
        $data = Token::where([
            'token' => $token
        ])->first();

        //8. トークンチェック
        if(is_null($data)){
            //DBから値が返ってこないのでトークンが間違っている、チェックNG
            return "WRONG";
        }else if($data->auth_flag){
            //検索して見つかったトークンデータの認証フラグが既に立っている(=認証済み)、チェックNG
            return "ALREADY";
        }

        $expire_date = new DateTime($data->expire_at);

        //9. 認証処理(有効なトークンだった場合はフラグを認証済み(true)に更新)
        if($now < $expire_date){
            $data->auth_flag = true;
            $data->update();
            return "OK";
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

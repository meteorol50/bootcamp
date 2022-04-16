<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\User;


class changePassword extends Controller
{
    public function changeP(Request $request)
    {
        #Emailを元にユーザーを特定
        $data = User::where([
            'email' => $request->email
        ])->first();

        #リクエストで送られた新規パスワードを＄passwordNewに代入
        $passwordNew = $request->passwordAfter;

        #パスワードと名前の一致確認（一致してたら変更）
        if ($data->name === $request->name & $data->password === $request->passwordBefore)
        {
            $data->password = $passwordNew;
            $data->update();
            return redirect('user/login');
        }else{
            return ['message' => 'incorrect name or password!'];
        }
    }
}

<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\Resource;
use App\Models\User;

class ShowController extends Controller
{
    /**
     * show user
     *
     * @param  App\Models\User $user
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function __invoke(
        User $user
    )
    {
        // 1.データ取得
        // 1件だけなのでmodelからデータを取得する→リクエストが渡された時点でURLパスからUserモデルインスタンスが生成される。

        // 2 resourceでデータを整形する（単一jsonを渡す）
        // コンストラクタにモデルを渡すとResourceクラス内のオブジェクトとしてアクセスできる。
        $user_resource = new Resource($user);

        // 2.結果を返す
        return $user_resource;
    }
}

<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Repositories\User\UserRepository;
use App\Http\Resources\Admin\User\Resource;
use App\Models\User;

class UpdateController extends Controller
{
    /**
     * update user
     *
     * @param  App\Models\User $user
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function __invoke(
        User $user,
        UpdateRequest $request,
        UserRepository $user_repository
    )
    {
        // 1.バリデーション済みの入力パラメータを取得
        $params = $request->validated();

        // 2.ユーザマスタ更新
        $updated_user = $user_repository->updateUser($user->id, $params);

        // 3 resourceでデータを整形する（更新後データを渡す）
        // リソースクラスの引数ににモデルを渡すとResourceクラス内のオブジェクトとしてアクセスできる。
        $user_resource = new Resource($updated_user);

        // 4.結果を返す（更新後データを返す）
        return $user_resource;
    }
}

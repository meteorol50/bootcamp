<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\IndexRequest;
use App\Repositories\User\UserRepository;
use App\Http\Resources\Admin\User\Collection;

// use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    /**
     * index users
     *
     * @param  IndexUserRequest  $request
     * @param  UserRepository  $request
     * @return Illuminate\Http\Response
     */
    public function __invoke(
        IndexRequest $request,
        UserRepository $user_repository
    )
    {
        // 1.データ取得
        // 【TODO：repositoryは一旦interfaceなしで開発。あとで追加するかも。】
        // 1.1 repositoryからデータを取得する(paginaterも一緒に取得)
        $users_data = $user_repository->getUsers([
            'email'          => $request->input('email'),
            'name'           => $request->input('name'),
            'tel'            => $request->input('tel'),
            'type_comp'      => $request->input('type_comp'),       // ユーザ区分：法人
            'type_sole_comp' => $request->input('type_sole_comp'),  // ユーザ区分：個人事業主
            'type_indvl'     => $request->input('type_indvl'),      // ユーザ区分：個人
            'per_page'       => $request->input('per_page', 20),    // 1ページ当たりのページ数
            'page'           => $request->input('page', 1),         // ページ数
            ]
        );

        // 1.2 resourceでデータを整形する（collectionを渡す）
        // 一覧の場合はResourceクラスとCollectionクラスが密結合になってしまうが、パフォーマンスを考慮し、やむなし。
        $users_resources = new Collection($users_data);

        // 2.結果を返す
        return $users_resources;

    }
}

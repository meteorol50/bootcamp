<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Company;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository {

    /**
     * Get users.
     *
     * @param  array $params
     * @return Collection|LengthAwarePaginator
     */
    public static function getUsers($params)
    {
        $users_company = [];
        $users_indivisual = [];

        $options = [
            'email'          => $params['email'] ?? null,           // メールアドレス
            'name'           => $params['name'] ?? null,            // 名前
            'tel'            => $params['tel'] ?? null,             // 電話番号
            'type_comp'      => $params['type_comp'] ?? null,       // ユーザ区分：法人
            'type_sole_comp' => $params['type_sole_comp'] ?? null,  // ユーザ区分：個人事業主
            'type_indvl'     => $params['type_indvl'] ?? null,      // ユーザ区分：個人
            'per_page'       => $params['per_page'] ?? null,        // 1ページ当たりのページ数
            'page'           => $params['page'] ?? 1,               // ページ数
            'order_by'       => 'updated_at desc'                   // ソート順　※初期開発時は固定。
        ];

        // ユーザタイプ＝法人・個人事業主と個人の場合
        if(($options['type_comp'] || $options['type_sole_comp']) && $options['type_indvl']){
            Log::info('■■■ユーザタイプ＝法人・個人事業主と個人の場合');

            // タイプを識別する
            $type = [];
            if ($options['type_comp']) {
                $type[] = 1; // 1:法人
            };
            if ($options['type_sole_comp']) {
                $type[] = 2; // 2:個人事業主
            };

            // ユーザデータを取得する。
            // 法人/個人事業主
            $users_company = User::query()
                ->select([
                    'users.id' ,
                    'companies.type' ,
                    'companies.image'  ,
                    'companies.name'  ,
                    'companies.tel' ,
                    'users.email' ,
                    'users.status' ,
                    'users.updated_at'
                ])
                ->join('companies', 'users.company_id', '=', 'companies.id')
                ->whereIn('companies.type', $type)
                ->when($options['email'], function($query, $value){
                    return $query->where('users.email', $value);
                })
                ->when($options['name'], function($query, $value){
                    return $query->where('companies.name', 'like' , '%' . $value . '%');
                })
                ->when($options['tel'], function($query, $value){
                    return $query->where('companies.tel', 'like' , '%' . $value . '%');
                });

            // 個人プロフィール情報
            $users = User::query()
                ->select([
                    'users.id' ,
                    DB::raw("'3' as `type`"),
                    'user_info.image'  ,
                    'user_info.name'  ,
                    'user_info.tel' ,
                    'users.email' ,
                    'users.status' ,
                    'users.updated_at'
                ])
                ->join('user_info', 'users.user_info_id', '=', 'user_info.id')
                ->when($options['email'], function($query, $value){
                    return $query->where('users.email', $value);
                })
                ->when($options['name'], function($query, $value){
                    return $query->where('user_info.name', 'like' , '%' . $value . '%');
                })
                ->when($options['tel'], function($query, $value){
                    return $query->where('user_info.tel', 'like' , '%' . $value . '%');
                })
                ->unionAll($users_company) // companyテーブルの結果をUnionAllする
                ->orderByRaw($options['order_by'])
                ->paginate($options['per_page'], ['*'], 'page', $options['page'])
                ;

            return $users;

        };

        // ユーザタイプ＝法人・個人事業主のみの場合
        if($options['type_comp'] || $options['type_sole_comp']){
            Log::info('■■■ユーザタイプ＝法人・個人事業主のみの場合');

            // タイプを識別する
            $type = [];
            if ($options['type_comp']) {
                $type[] = 1; // 1:法人
            };
            if ($options['type_sole_comp']) {
                $type[] = 2; // 2:個人事業主
            };

            // ユーザデータを取得する。
            $users_company = User::query()
                ->select([
                    'users.id' ,
                    'companies.type' ,
                    'companies.image'  ,
                    'companies.name'  ,
                    'companies.tel' ,
                    'users.email' ,
                    'users.status' ,
                    'users.updated_at'
                ])
                ->join('companies', 'users.company_id', '=', 'companies.id')
                ->whereIn('companies.type', $type)
                ->when($options['email'], function($query, $value){
                    return $query->where('users.email', $value);
                })
                ->when($options['name'], function($query, $value){
                    return $query->where('companies.name', 'like' , '%' . $value . '%');
                })
                ->when($options['tel'], function($query, $value){
                    return $query->where('companies.tel', 'like' , '%' . $value . '%');
                })
                ->orderByRaw($options['order_by'])
                ->paginate($options['per_page'], ['*'], 'page', $options['page'])
                ;

            return $users_company;

        };

        // ユーザタイプ＝個人の場合
        if($options['type_indvl']){
            Log::info('■■■ユーザタイプ＝個人の場合');
            // 個人プロフィール情報
            $users_indivisual = User::query()
                ->select([
                    'users.id' ,
                    DB::raw("'3' as `type`"),
                    'user_info.image'  ,
                    'user_info.name'  ,
                    'user_info.tel' ,
                    'users.email' ,
                    'users.status' ,
                    'users.updated_at'
                ])
                ->join('user_info', 'users.user_info_id', '=', 'user_info.id')
                ->when($options['email'], function($query, $value){
                    return $query->where('users.email', $value);
                })
                ->when($options['name'], function($query, $value){
                    return $query->where('user_info.name', 'like' , '%' . $value . '%');
                })
                ->when($options['tel'], function($query, $value){
                    return $query->where('user_info.tel', 'like' , '%' . $value . '%');
                })
                ->orderByRaw($options['order_by'])
                ->paginate($options['per_page'], ['*'], 'page', $options['page'])
                ;

            return $users_indivisual;

        };
    }

    /**
     * Update user.
     *
     * @param  Integer $user_id
     * @param  array $params[image,name,tel,other]
     * @return User $user
     */
    public static function updateUser(int $user_id, array $params = [] )
    {

        // ユーザマスタ更新
        $user = User::find($user_id);
        $user->fill([
            'email' => $params['email']
        ]);
        $user->save();

        // 詳細テーブル更新
        if ($user->user_info_id){
            // 個人のプロフィール情報を更新
            $user->userInfo->fill([
                'image' =>  $params['image'],
                'name'  =>  $params['name'],
                'tel'   =>  $params['tel'],
                'other' =>  $params['other'],
            ]);

            $user->userInfo->save();

        } else {
            // 法人/個人事業主情報を更新
            $user->company->fill([
                'image' =>  $params['image'],
                'name'  =>  $params['name'],
                'tel'   =>  $params['tel'],
                'other' =>  $params['other'],
            ]);

            $user->company->save();

        }

        return $user;

    }
}

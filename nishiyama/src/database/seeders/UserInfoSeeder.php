<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserInfo;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserInfo::create([
            // 'id'=>'',   // ID(自動採番)
            'name'          =>'sample_user4',     // 名前
            'image'         =>null,              // プロフィール画像パス
            'postal_code'   =>'000-0004',  // 郵便番号
            'prefecture_id' =>1,         // 都道府県【TODO:prefecture_idが不明なため仮で登録】
            'city'          =>'〇〇市',                 // 市区町村
            'address'       =>'△△町',              // 番地
            'building'      =>'××マンション',       // 建物名
            'tel'           =>'0334630041',            // 電話番号
            'fax'           =>'0334630042',            //FAX番号
            'other'         =>'サンプルユーザ4(個人)',   // その他
            'shipping_id'   =>1,               // 既定の配送先 【TODO:仮設定】
            // 'created_at'=>'', // 作成日(デフォルト値)
            // 'updated_at'=>'', // 更新日(デフォルト値)
            'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
            'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
        ]);
        UserInfo::create([
            // 'id'=>'',   // ID(自動採番)
            'name'          =>'sample_user5',     // 名前
            'image'         =>null,              // プロフィール画像パス
            'postal_code'   =>'000-0005',  // 郵便番号
            'prefecture_id' =>1,         // 都道府県【TODO:prefecture_idが不明なため仮で登録】
            'city'          =>'〇〇市',                 // 市区町村
            'address'       =>'△△町',              // 番地
            'building'      =>'××マンション',       // 建物名
            'tel'           =>'0334630041',            // 電話番号
            'fax'           =>'0334630042',            //FAX番号
            'other'         =>'サンプルユーザ5(個人)',   // その他
            'shipping_id'   =>1,               // 既定の配送先 【TODO:仮設定】
            // 'created_at'=>'', // 作成日(デフォルト値)
            // 'updated_at'=>'', // 更新日(デフォルト値)
            'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
            'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
        ]);
        UserInfo::create([
            // 'id'=>'',   // ID(自動採番)
            'name'          =>'sample_user6',     // 名前
            'image'         =>null,              // プロフィール画像パス
            'postal_code'   =>'000-0006',  // 郵便番号
            'prefecture_id' =>1,         // 都道府県【TODO:prefecture_idが不明なため仮で登録】
            'city'          =>'〇〇市',                 // 市区町村
            'address'       =>'△△町',              // 番地
            'building'      =>'××マンション',       // 建物名
            'tel'           =>'0334630041',            // 電話番号
            'fax'           =>'0334630042',            //FAX番号
            'other'         =>'サンプルユーザ6(個人)',   // その他
            'shipping_id'   =>1,               // 既定の配送先 【TODO:仮設定】
            // 'created_at'=>'', // 作成日(デフォルト値)
            // 'updated_at'=>'', // 更新日(デフォルト値)
            'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
            'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
        ]);
        UserInfo::create([
            // 'id'=>'',   // ID(自動採番)
            'name'          =>'sample_user7',     // 名前
            'image'         =>null,              // プロフィール画像パス
            'postal_code'   =>'000-0004',  // 郵便番号
            'prefecture_id' =>1,         // 都道府県【TODO:prefecture_idが不明なため仮で登録】
            'city'          =>'〇〇市',                 // 市区町村
            'address'       =>'△△町',              // 番地
            'building'      =>'××マンション',       // 建物名
            'tel'           =>'0334630041',            // 電話番号
            'fax'           =>'0334630042',            //FAX番号
            'other'         =>'サンプルユーザ7(個人)',   // その他
            'shipping_id'   =>1,               // 既定の配送先 【TODO:仮設定】
            // 'created_at'=>'', // 作成日(デフォルト値)
            // 'updated_at'=>'', // 更新日(デフォルト値)
            'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
            'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
        ]);
        UserInfo::create([
            // 'id'=>'',   // ID(自動採番)
            'name'          =>'sample_user8',     // 名前
            'image'         =>null,              // プロフィール画像パス
            'postal_code'   =>'000-0008',  // 郵便番号
            'prefecture_id' =>1,         // 都道府県【TODO:prefecture_idが不明なため仮で登録】
            'city'          =>'〇〇市',                 // 市区町村
            'address'       =>'△△町',              // 番地
            'building'      =>'××マンション',       // 建物名
            'tel'           =>'0334630041',            // 電話番号
            'fax'           =>'0334630042',            //FAX番号
            'other'         =>'サンプルユーザ8(個人)',   // その他
            'shipping_id'   =>1,               // 既定の配送先 【TODO:仮設定】
            // 'created_at'=>'', // 作成日(デフォルト値)
            // 'updated_at'=>'', // 更新日(デフォルト値)
            'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
            'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
        ]);
    }
}

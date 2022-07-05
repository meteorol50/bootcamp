<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データ作成
        $companies = [
            [
                // 'id'            =>'',                    // 自動採番
                'type'          => 1,                       // 法人/個人事業主フラグ(1:法人, 2:個人事業主)
                'name'          => 'sample_user1_company',    // 事業者名/屋号
                'image'         => null,                    // プロフィール画像パス
                'postal_code'   => '000-0001',              // 郵便番号
                'prefecture_id' => 1,                       // 都道府県【TODO:prefecture_idが不明なため仮で登録】
                'city'          => '渋谷区',                 // 市区町村
                'address'       => '代々木',                 // 番地
                'building'      => '清水代々木ビル',           // 建物名
                'tel'           => '0334630011',           // 電話番号
                'fax'           => '0334630012',           // FAX番号
                'other'         => 'サンプルユーザ1(法人)',     // その他
                'shipping_id'   => 1,                      // 既定の配送先 【TODO:仮設定】
                // 'created_at'    => '',                      // 作成日(デフォルト値)
                // 'updated_at'    => '',                      // 更新日(デフォルト値)
                'created_by'    => 1,                       // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,                       // 更新者 【TODO:何が入る？仮設定】
            ],
            [
                // 'id'            =>'',                    // 自動採番
                'type'          => 1,                       // 法人/個人事業主フラグ(1:法人, 2:個人事業主)
                'name'          => 'sample_user2_company',    // 事業者名/屋号
                'image'         => null,                    // プロフィール画像パス
                'postal_code'   => '000-0002',              // 郵便番号
                'prefecture_id' => 1,                       // 都道府県【TODO:prefecture_idが不明なため仮で登録】
                'city'          => '渋谷区',                 // 市区町村
                'address'       => '上原',                   // 番地
                'building'      => '△△ビル',               // 建物名
                'tel'           => '0334630021',           // 電話番号
                'fax'           => '0334630022',           // FAX番号
                'other'         => 'サンプルユーザ2(法人)',     // その他
                'shipping_id'   => 1,                      // 既定の配送先 【TODO:仮設定】
                // 'created_at'    => '',                      // 作成日(デフォルト値)
                // 'updated_at'    => '',                      // 更新日(デフォルト値)
                'created_by'    => 1,                       // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,                       // 更新者 【TODO:何が入る？仮設定】
            ],
            [
                // 'id'            =>'',                        // 自動採番
                'type'          => 2,                           // 法人/個人事業主フラグ(1:法人, 2:個人事業主)
                'name'          => 'sample_user3_solo_person',  // 事業者名/屋号
                'image'         => null,                        // プロフィール画像パス
                'postal_code'   => '000-0003',                  // 郵便番号
                'prefecture_id' => 1,                           // 都道府県【TODO:prefecture_idが不明なため仮で登録】
                'city'          => '新宿区',                        // 市区町村
                'address'       => '西新宿',                        // 番地
                'building'      => '〇〇ビル',                      // 建物名
                'tel'           => '0334630031',                    // 電話番号
                'fax'           => '0334630032',                // FAX番号
                'other'         => 'サンプルユーザ3(個人事業主)',       // その他
                'shipping_id'   => 1,                           // 既定の配送先 【TODO:仮設定】
                // 'created_at'    => '',                      // 作成日(デフォルト値)
                // 'updated_at'    => '',                      // 更新日(デフォルト値)
                'created_by'    => 1,                           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,                           // 更新者 【TODO:何が入る？仮設定】
            ]
        ];

        // データ登録
        Company::insert($companies);

    }
}

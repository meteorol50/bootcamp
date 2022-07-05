<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\UserInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データ作成
        $users = [
            // 1
            [
                // 'id'=>'', // ID(自動採番)
                'status'                    =>0, // ステータス
                'email'                     =>'sample_user1@gmail.com', // メールアドレス
                'company_id'                =>Company::where('name', 'sample_user1_company')->first()->id, // 法人/個人事業主ID
                'user_info_id'              =>null, // 個人プロフィールID
                'verification_code'         =>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'                =>Carbon::now()->addDay(7), // 有効期限
                'verified_at'               =>Carbon::now(), // 承認日時
                'crypted_password'          =>Hash::make('password'), // パスワード
                'salt'                      =>null, // ソルト【TODO：何が入る？】
                'access_token'              =>null, // アクセストークン
                'reset_password_token'      =>null, // パスワード再設定トークン
                'reset_password_expired_at' =>null, // パスワード再設定 有効期限
                'last_login_at'             =>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'               =>1, // ログイン回数
                'withdraw_count'            =>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'                => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'                => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 2
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user2@gmail.com', // メールアドレス
                'company_id'=>Company::where('name', 'sample_user2_company')->first()->id, // 法人/個人事業主ID
                'user_info_id'=>null, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 3
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user3@gmail.com', // メールアドレス
                'company_id'=>Company::where('name', 'sample_user3_solo_person')->first()->id, // 法人/個人事業主ID
                'user_info_id'=>null, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 4
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user4@gmail.com', // メールアドレス
                'company_id'=>null, // 法人/個人事業主ID
                'user_info_id'=>UserInfo::where('name', 'sample_user4')->first()->id, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 5
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user5@gmail.com', // メールアドレス
                'company_id'=>null, // 法人/個人事業主ID
                'user_info_id'=>UserInfo::where('name', 'sample_user4')->first()->id, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 6
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user6@gmail.com', // メールアドレス
                'company_id'=>null, // 法人/個人事業主ID
                'user_info_id'=>UserInfo::where('name', 'sample_user4')->first()->id, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 7
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user7@gmail.com', // メールアドレス
                'company_id'=>null, // 法人/個人事業主ID
                'user_info_id'=>UserInfo::where('name', 'sample_user4')->first()->id, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
            // 8
            [
                // 'id'=>'', // ID(自動採番)
                'status'=>1, // ステータス
                'email'=>'sample_user8@gmail.com', // メールアドレス
                'company_id'=>null, // 法人/個人事業主ID
                'user_info_id'=>UserInfo::where('name', 'sample_user4')->first()->id, // 個人プロフィールID
                'verification_code'=>12345, // 認証番号 【TODO：何が入る？数値型？】
                'expired_at'=>Carbon::now()->addDay(7), // 有効期限
                'verified_at'=>Carbon::now(), // 承認日時
                'crypted_password'=>Hash::make('password'), // パスワード
                'salt'=>null, // ソルト【TODO：何が入る？】
                'access_token'=>null, // アクセストークン
                'reset_password_token'=>null, // パスワード再設定トークン
                'reset_password_expired_at'=>null, // パスワード再設定 有効期限
                'last_login_at'=>Carbon::now()->subDay(3), // 最終ログイン日時
                'login_times'=>1, // ログイン回数
                'withdraw_count'=>0, // 退会回数
                // 'created_at'=>'', // 作成日(デフォルト値)
                // 'updated_at'=>'', // 更新日(デフォルト値)
                'created_by'    => 1,           // 作成者 【TODO:何が入る？仮設定】
                'updated_by'    => 1,           // 更新者 【TODO:何が入る？仮設定】
            ],
        ];

        // データ登録
        User::insert($users);

    }
}

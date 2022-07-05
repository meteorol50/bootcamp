<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // マスタ系は以下で登録する。その他トランザクション系データは個別実行
        // \App\Models\User::factory(10)->create();
        $this->call([
            CompanySeeder::class,
            UserInfoSeeder::class,
            UserSeeder::class
        ]);
    }
}

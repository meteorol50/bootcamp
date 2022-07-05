環境構築手順

1 LAMP環境を構築する
    ・Webサーバー
    ・DBサーバー
    ・PHP
    ※バージョン等については以下のURLを参照
        https://docs.google.com/spreadsheets/d/1ZMeHQtCn2l8USsJn7f6p0xozMk6_1MyLS8P8A12aL2c/edit#gid=0

2 コンポーザーのインストール
    composerをinstallする

3 DB作成

4 Laravelのインストール
    ※ソースはGithubより取得
        https://github.com/agtech-lab/uzone_api.git

    4-1 Laravelの設定
        4-1-1 Laravelディレクトリに移動
        4-1-2 コマンド実行
                composer install
    4-2 .envファイル設定
        4-2-1 個人の環境に合わせて修正する
            DB_DATABASE
            DB_USERNAME
            DB_PASSWORD

    4-3 マイグレート実行
        php artisan migrate

5 Node.jsのインストール
    https://nodejs.org/ja/download/






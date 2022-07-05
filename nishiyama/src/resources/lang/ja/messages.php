<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Error messages which are part of response
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'invalid_token' => 'トークンが無効または期限切れです',
    'bad_request' => '何かが間違っていました。もう一度やり直してください',
    'unauthorized' => '認証されていない',
    'payment_required' => 'さらに先に進むには支払いが必要です',
    'forbidden' => 'このリソースを表示する権限がありません',
    'not_found' => '見つかりません',
    'method_not_allowed' => '方法は許可されていません',
    'conflict' => '重複するリソースが見つかりました',
    'unprocessable_entity' => '指定されたデータは無効でした。',
    'too_many_requests' => 'サーバーに送信されたリクエストが多すぎます',
    'internal_server_error' => '内部サーバーエラー。詳細については、システム管理者にお問い合わせください',
    'failed' => '認証に失敗しました',
    'throttle' => 'ログイン試行回数が制限に達しました。 :seconds 秒以上開けて再度お試しください',
    'password' => '指定されたパスワードが正しくありません。',
    'email_not_found' => 'メールアドレスが見つかりませんでした。',
    'recovery_mail_sent' => '復旧メールがあなたのメールアドレスに送信されました。',
    'recovery_mail_not_sent' => 'リカバリメールを送信できませんでした。',
    'reset_token_not_found' => 'リセットパスワードトークンが見つかりません。',
    'reset_token_expired' => 'パスワードリセットトークンの有効期限が切れています。新しいリクエストを生成してください。',
    'password_updated' => 'パスワードは正常に更新されました。続行するにはログインしてください。',
    'two_factor_auth_failed' => '二要素認証に失敗しました',
    'register_mail_link_sent' => '登録リンクがあなたのメールアドレスに送信されました。',
    'logout_successful' => '正常にログアウトしました。',
    'invalid_credentials' => '無効な資格情報',
    'account_invalid' => '無効なアカウント',
    'login_success' => 'ログイン成功',
    'invalid_access' => '不正なアクセスです。',
    'password_reset_token_expired' => 'パスワード再設定の有効期限が切れました。改めてパスワード再設定をお願いします。',
    'invalid_token' => 'トークンが無効です',
    'old_new_password_same' => '新しいパスワードを古いパスワードと同じにすることはできません',


    'request_successful' => "リクエストは正常に完了しました。",
     'creation_successful' => "要求されたデータは正常に作成されました。",
     'acceptance_successful' => "リクエストを処理します。",
     'deletion_successful' => "リソースが正常に削除されました。",

     'validation_error' => "指定されたデータは無効でした。",

     //Uzone Error messages
    'email_already_registered' => "メールアドレスが重複しています。",
    'mail_transmission_error' => "メール送信に失敗しました。メールアドレスが正しいかご確認お願いします。",

    'verification_code_incorrect' => "認証コードが誤りです。正しい認証コードを入力してください。",
    'verification_code_expired' => "認証コードの有効期限が切れています。メールアドレス入力から再度お願いします。",
    'user_info_already_registered' => "このユーザーの情報はすでに登録されています。更新機能を使用してください。",
    'cannot_delete_incharge' => '担当者を編集する削除がありません',
    'cannot_edit_incharge' => '担当者を編集する権限がありません',
    'incharge_deleted' => '担当者を削除',
    'unauthorised_shipping_update' => '配送先を編集する権限がありません。',
    'image_height_width_mismatch' => '画像の高さと幅は異なります。比率は1：1である必要があります。'

];

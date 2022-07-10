<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <header>
            <h1>Uzone会員登録</h1>
        </header>
        <div class="container">
            <h2>メール認証</h2>
            <p>6桁の認証コードを入力してください。</p>
            <form method="post" action="{{ route('email_authentications.authenticate') }}">
                @csrf
                <label>
                    メールアドレス
                    <input type="email" name="email">
                </label>
                <label>
                    認証コード
                    <input type="text" name="auth_code">
                </label>
                <button>認証</button>
            </form>
        </div>
    </body>
</html>

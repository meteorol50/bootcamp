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
            <h2>お客様情報入力</h2>
            <p>入力していただいたメールアドレス宛に、6桁の認証コードを送信します。</p>
            <form method="post" action="{{ route('email_authentications.store') }}">
                @csrf
                <label>
                    会社名
                    <input type="text" name="name">
                </label>
                <label>
                    メールアドレス
                    <input type="email" name="email">
                </label>
                <label>
                    パスワード
                    <input type="password" name="password">
                </label>
                <button>送信</button>
            </form>
        </div>
    </body>
</html>

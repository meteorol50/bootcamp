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
            <p>メールアドレスを入力してください。入力していただいたメールアドレス宛に、6桁の認証コードを送信します。</p>
            <form method="post" action="{{ route('email_authentications.store') }}">
                @csrf
                <label>
                    メールアドレス
                    <input type="text" name="email">
                </label>
                <button>認証コードを送信する</button>
            </form>
        </div>
    </body>
</html>

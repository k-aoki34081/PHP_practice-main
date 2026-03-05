<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | 掲示板アプリ</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- ===========================================
     ログインフォーム
     =========================================== -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- -----------------------------------------
             タイトル
             ----------------------------------------- -->
            <h1 class="auth-title">ログイン</h1>
            <p class="auth-subtitle">アカウント情報を入力してください</p>

            <!-- -----------------------------------------
             ログインフォーム
             action="login_act.php" で認証処理に送信
             method="POST" でPOSTメソッドを使用
             ----------------------------------------- -->
            <form method="POST" action="login_act.php" class="auth-form">
                <!-- -----------------------------------------
                 メールアドレス入力欄
                 name="email" でPHPから $_POST["email"] で取得可能
                 ----------------------------------------- -->
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email"
                        placeholder="メールアドレスを入力"
                        required
                        autocomplete="email">
                </div>

                <!-- -----------------------------------------
                 パスワード入力欄
                 name="password" でPHPから $_POST["password"] で取得可能
                 type="password" で入力内容を非表示
                 ----------------------------------------- -->
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password"
                        placeholder="パスワードを入力"
                        required
                        autocomplete="current-password">
                </div>

                <!-- -----------------------------------------
                 ログインボタン
                 ----------------------------------------- -->
                <button type="submit" class="btn btn-primary">ログイン</button>
            </form>

            <!-- -----------------------------------------
             新規登録リンク
             ----------------------------------------- -->
            <div class="auth-links">
                アカウントをお持ちでない方は<br>
                <a href="register.php">新規登録はこちら</a>
            </div>

            <!-- -----------------------------------------
             テストアカウント情報
             ※開発・学習用。本番では削除すること
             ----------------------------------------- -->
            <div class="auth-hint">
                <div class="auth-hint-title">テストアカウント</div>
                <div class="auth-hint-content">
                    Email: <code>test@example.com</code><br>
                    Password: <code>test123</code>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
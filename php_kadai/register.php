<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録 | 掲示板アプリ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===========================================
     新規登録フォーム
     =========================================== -->
<div class="auth-container">
    <div class="auth-card">
        <!-- -----------------------------------------
             タイトル
             ----------------------------------------- -->
        <h1 class="auth-title">新規登録</h1>
        <p class="auth-subtitle">アカウントを作成してください</p>

        <!-- -----------------------------------------
             登録フォーム
             action="register_act.php" で登録処理に送信
             method="POST" でPOSTメソッドを使用
             ----------------------------------------- -->
        <form method="POST" action="register_act.php" class="auth-form">
            <!-- -----------------------------------------
                 ユーザー名入力欄
                 name="name" でPHPから $_POST["name"] で取得可能
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" 
                       placeholder="ユーザー名を入力" 
                       required>
            </div>

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
                       autocomplete="new-password">
            </div>

            <!-- -----------------------------------------
                 登録ボタン
                 ----------------------------------------- -->
            <button type="submit" class="btn btn-primary">登録する</button>
        </form>

        <!-- -----------------------------------------
             ログインリンク
             ----------------------------------------- -->
        <div class="auth-links">
            すでにアカウントをお持ちの方は<br>
            <a href="login.php">ログインはこちら</a>
        </div>
    </div>
</div>

</body>
</html>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | PHP03 ユーザー認証システム</title>
    <!-- 自作CSSを読み込み -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===========================================
     ログインフォーム
     =========================================== -->
<div class="login-container">
    <div class="login-card">
        <!-- -----------------------------------------
             タイトル
             ----------------------------------------- -->
        <h1 class="login-title">ログイン</h1>
        <p class="login-subtitle">アカウント情報を入力してください</p>

        <!-- -----------------------------------------
             ログインフォーム
             action="login_act.php" で認証処理に送信
             method="POST" でPOSTメソッドを使用
             ----------------------------------------- -->
        <form method="POST" action="login_act.php" class="login-form">
            <!-- -----------------------------------------
                 ログインID入力欄
                 name="lid" でPHPから $_POST["lid"] で取得可能
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="lid">ログインID</label>
                <input type="text" name="lid" id="lid" 
                       placeholder="ログインIDを入力" 
                       required 
                       autocomplete="username">
            </div>

            <!-- -----------------------------------------
                 パスワード入力欄
                 name="lpw" でPHPから $_POST["lpw"] で取得可能
                 type="password" で入力内容を非表示
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="lpw">パスワード</label>
                <input type="password" name="lpw" id="lpw" 
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
             テストアカウント情報
             ※開発・学習用。本番では削除すること
             ----------------------------------------- -->
        <div class="login-hint">
            <div class="login-hint-title">📝 テストアカウント</div>
            <div class="login-hint-content">
                <strong>管理者：</strong><br>
                ID: <code>admin</code> / PW: <code>admin123</code><br><br>
                <strong>一般ユーザー：</strong><br>
                ID: <code>user1</code> / PW: <code>user123</code>
            </div>
        </div>
    </div>
</div>

</body>
</html>


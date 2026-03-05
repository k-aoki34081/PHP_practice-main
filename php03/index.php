<?php
// ===========================================
// データ登録画面（index.php）
// ===========================================
// セッションチェックを追加
// ログイン済みユーザーのみアクセス可能
// ===========================================

// -----------------------------------------
// 1. セッション開始（最初に記述必須！）
// -----------------------------------------
session_start();

// -----------------------------------------
// 2. 共通関数ファイルを読み込み
// -----------------------------------------
include("funcs.php");

// -----------------------------------------
// 3. ログイン状態をチェック
// -----------------------------------------
// 未ログインの場合はエラー画面を表示
// -----------------------------------------
sschk();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ登録 | PHP03 ユーザー認証システム</title>
    <!-- 自作CSSを読み込み -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===========================================
     ナビゲーション
     =========================================== -->
<nav class="navbar">
    <a class="navbar-brand" href="select.php">PHP03 認証システム</a>
    <div class="navbar-links">
        <a href="index.php">新規登録</a>
        <a href="select.php">データ一覧</a>
    </div>
    <!-- -----------------------------------------
         ユーザー情報とログアウト
         ----------------------------------------- -->
    <div class="navbar-user">
        <span class="navbar-user-info">
            <span class="navbar-user-name"><?= h($_SESSION["name"]) ?></span>
            <?php if ($_SESSION["kanri_flg"] == 1): ?>
                <span class="badge badge-admin">管理者</span>
            <?php else: ?>
                <span class="badge badge-user">一般</span>
            <?php endif; ?>
        </span>
        <a href="logout.php" class="logout-link">ログアウト</a>
    </div>
</nav>

<!-- ===========================================
     メインコンテンツ
     =========================================== -->
<div class="container">
    <h1 class="page-title">アンケート登録</h1>

    <!-- -----------------------------------------
         登録フォーム
         action="insert.php" でフォーム送信先を指定
         method="POST" でPOSTメソッドを使用
         ----------------------------------------- -->
    <div class="card">
        <h2 class="card-title">フリーアンケート</h2>

        <form method="POST" action="insert.php">
            <!-- -----------------------------------------
                 名前入力欄
                 name="name" でPHPから $_POST["name"] で取得可能
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="name">お名前</label>
                <input type="text" name="name" id="name" placeholder="例: 山田太郎">
            </div>

            <!-- -----------------------------------------
                 メールアドレス入力欄
                 name="email" でPHPから $_POST["email"] で取得可能
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" placeholder="例: example@email.com">
            </div>

            <!-- -----------------------------------------
                 内容入力欄（テキストエリア）
                 name="naiyou" でPHPから $_POST["naiyou"] で取得可能
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="naiyou">ご意見・ご感想</label>
                <textarea name="naiyou" id="naiyou" placeholder="ご自由にお書きください"></textarea>
            </div>

            <!-- -----------------------------------------
                 送信ボタン
                 クリックで insert.php にデータが送信される
                 ----------------------------------------- -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">登録する</button>
                <a href="select.php" class="btn btn-secondary">一覧を見る</a>
            </div>
        </form>
    </div>
</div>

<!-- ===========================================
     フッター
     =========================================== -->
<footer class="footer">
    <p>PHP03 ユーザー認証システム - セッション・認証の学習用</p>
</footer>

</body>
</html>


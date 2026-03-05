<?php
// ===========================================
// 新規投稿画面（create.php）
// ===========================================
// ログイン済みユーザーのみアクセス可能
// ===========================================


// -----------------------------------------
// 1. セッション開始
// -----------------------------------------
session_start();


// -----------------------------------------
// 2. 共通関数ファイルを読み込み
// -----------------------------------------
include("funcs.php");


// -----------------------------------------
// 3. ログイン状態をチェック
// -----------------------------------------
sschk();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規投稿 | 掲示板アプリ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===========================================
     ナビゲーション
     =========================================== -->
<nav class="navbar">
    <a class="navbar-brand" href="index.php">掲示板アプリ</a>
    <div class="navbar-links">
        <a href="index.php">投稿一覧</a>
        <a href="create.php">新規投稿</a>
    </div>
    <div class="navbar-user">
        <span class="navbar-user-info">
            <span class="navbar-user-name"><?= h($_SESSION["user_name"]) ?></span>
        </span>
        <a href="logout.php" class="logout-link">ログアウト</a>
    </div>
</nav>

<!-- ===========================================
     メインコンテンツ
     =========================================== -->
<div class="container">
    <h1 class="page-title">新規投稿</h1>

    <div class="card">
        <!-- -----------------------------------------
             投稿フォーム
             action="create_act.php" で登録処理に送信
             method="POST" でPOSTメソッドを使用
             ----------------------------------------- -->
        <form method="POST" action="create_act.php">
            <!-- -----------------------------------------
                 投稿内容入力欄
                 name="content" でPHPから $_POST["content"] で取得可能
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="content">投稿内容</label>
                <textarea name="content" id="content" 
                          placeholder="投稿内容を入力してください" 
                          required></textarea>
            </div>

            <!-- -----------------------------------------
                 ボタン
                 ----------------------------------------- -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">投稿する</button>
                <a href="index.php" class="btn btn-secondary">キャンセル</a>
            </div>
        </form>
    </div>
</div>

<!-- ===========================================
     フッター
     =========================================== -->
<footer class="footer">
    <p>PHP課題 掲示板アプリ - CRUD + ログイン機能の学習用</p>
</footer>

</body>
</html>


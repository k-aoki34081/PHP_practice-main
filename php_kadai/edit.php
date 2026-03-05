<?php
// ===========================================
// 投稿編集画面（edit.php）
// ===========================================
// ログイン済みユーザーのみアクセス可能
// 自分の投稿のみ編集可能
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


// -----------------------------------------
// 4. GETパラメータからIDを取得
// -----------------------------------------
$id = $_GET["id"];


// -----------------------------------------
// 5. DB接続
// -----------------------------------------
$pdo = db_conn();


// -----------------------------------------
// 6. 投稿データを取得
// -----------------------------------------
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}

$post = $stmt->fetch();


// -----------------------------------------
// 7. 自分の投稿かチェック
// -----------------------------------------
if (!$post || $post["user_id"] != $_SESSION["user_id"]) {
    redirect("index.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿編集 | 掲示板アプリ</title>
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
    <h1 class="page-title">投稿編集</h1>

    <div class="card">
        <!-- -----------------------------------------
             編集フォーム
             action="update_act.php" で更新処理に送信
             method="POST" でPOSTメソッドを使用
             ----------------------------------------- -->
        <form method="POST" action="update_act.php">
            <!-- -----------------------------------------
                 隠しフィールドでIDを送信
                 ----------------------------------------- -->
            <input type="hidden" name="id" value="<?= h($post["id"]) ?>">

            <!-- -----------------------------------------
                 投稿内容入力欄
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="content">投稿内容</label>
                <textarea name="content" id="content" 
                          required><?= h($post["content"]) ?></textarea>
            </div>

            <!-- -----------------------------------------
                 ボタン
                 ----------------------------------------- -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">更新する</button>
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


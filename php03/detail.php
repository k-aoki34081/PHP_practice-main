<?php
// ===========================================
// データ詳細・編集画面（detail.php）
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
sschk();


// -----------------------------------------
// 4. GETパラメータからIDを取得
// -----------------------------------------
// URLの ?id=1 の部分を取得
// 例: detail.php?id=5 → $id = 5
// -----------------------------------------
$id = $_GET["id"];


// -----------------------------------------
// 5. DB接続
// -----------------------------------------
$pdo = db_conn();


// -----------------------------------------
// 6. 指定IDのデータを取得するSELECT文
// -----------------------------------------
// WHERE id = :id で特定の1件のみ取得
// bindValue() でSQLインジェクション対策
// -----------------------------------------
$sql = "SELECT * FROM gs_an_table WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();


// -----------------------------------------
// 7. データ取得結果の処理
// -----------------------------------------
// fetch() で1件だけ取得（whileは不要）
// $row["カラム名"] でデータにアクセス
// -----------------------------------------
if ($status == false) {
    // SQLエラーの場合
    sql_error($stmt);
} else {
    // 1件のデータを取得
    $row = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ編集 | PHP03 ユーザー認証システム</title>
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
    <h1 class="page-title">アンケート編集</h1>

    <!-- -----------------------------------------
         編集フォーム
         action="update.php" で更新処理に送信
         method="POST" でPOSTメソッドを使用
         ----------------------------------------- -->
    <div class="card">
        <h2 class="card-title">データの編集</h2>

        <form method="POST" action="update.php">
            <!-- -----------------------------------------
                 名前入力欄
                 value="..." でDBから取得した値を初期値として表示
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="name">お名前</label>
                <input type="text" name="name" id="name" 
                       value="<?= h($row["name"]) ?>">
            </div>

            <!-- -----------------------------------------
                 メールアドレス入力欄
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" 
                       value="<?= h($row["email"]) ?>">
            </div>

            <!-- -----------------------------------------
                 内容入力欄（テキストエリア）
                 textareaは value ではなく、タグの中に値を書く
                 ----------------------------------------- -->
            <div class="form-group">
                <label for="naiyou">ご意見・ご感想</label>
                <textarea name="naiyou" id="naiyou"><?= h($row["naiyou"]) ?></textarea>
            </div>

            <!-- -----------------------------------------
                 隠しフィールド（hidden）
                 画面には表示されないが、フォーム送信時にIDを渡す
                 update.php でどのデータを更新するか特定するために必要
                 ----------------------------------------- -->
            <input type="hidden" name="id" value="<?= h($row["id"]) ?>">

            <!-- -----------------------------------------
                 ボタン
                 ----------------------------------------- -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">更新する</button>
                <a href="select.php" class="btn btn-secondary">一覧に戻る</a>
            </div>
        </form>
    </div>

    <!-- -----------------------------------------
         データ情報
         ----------------------------------------- -->
    <div class="card">
        <p class="text-muted">
            ID: <?= h($row["id"]) ?> | 
            登録日時: <?= h($row["indate"]) ?>
        </p>
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


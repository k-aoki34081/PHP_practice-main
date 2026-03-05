<?php
// ===========================================
// データ一覧表示（select.php）
// ===========================================
// セッションチェックを追加
// ログイン済みユーザーのみアクセス可能
// 管理者のみ削除ボタンを表示
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
// ★ 3. ログイン状態をチェック
// -----------------------------------------
// sschk();


// -----------------------------------------
// 4. DB接続
// -----------------------------------------
$pdo = db_conn();


// -----------------------------------------
// 5. SELECT文を作成・実行
// -----------------------------------------
// ORDER BY indate DESC で新しい順に取得
// -----------------------------------------
$sql = "SELECT * FROM gs_an_table ORDER BY indate DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


// -----------------------------------------
// 6. データ表示用のHTML文字列を生成
// -----------------------------------------
// while文でデータを1件ずつ取得
// FETCH_ASSOC で連想配列として取得
// -----------------------------------------
$view = "";

if ($status == false) {
    // SQLエラーの場合
    sql_error($stmt);
} else {
    // -----------------------------------------
    // データがある限りループ
    // $r["カラム名"] でデータにアクセス
    // h() 関数でXSS対策（必須！）
    // -----------------------------------------
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="list-item">';
        $view .= '  <div class="list-item-content">';
        
        // 編集画面へのリンク（GETパラメータでIDを渡す）
        $view .= '    <a href="detail.php?id=' . h($r["id"]) . '">';
        $view .= '      <strong>' . h($r["name"]) . '</strong>';
        $view .= '    </a>';
        
        // メタ情報（メール・日時）
        $view .= '    <div class="list-item-meta">';
        $view .= '      ' . h($r["email"]) . ' | ' . h($r["indate"]);
        $view .= '    </div>';
        
        $view .= '  </div>';
        
        // -----------------------------------------
        // 操作ボタン（編集・削除）
        // -----------------------------------------
        $view .= '  <div class="list-item-actions">';
        
        // 編集ボタン（全ユーザー共通）
        $view .= '    <a href="detail.php?id=' . h($r["id"]) . '" class="btn btn-secondary btn-sm">編集</a>';
        
        // -----------------------------------------
        // 削除ボタン（管理者のみ表示）
        // -----------------------------------------
        // $_SESSION["kanri_flg"] が 1 の場合のみ表示
        // onclick="return confirm()" で削除前に確認
        // -----------------------------------------
        if ($_SESSION["kanri_flg"] == 1) {
            $view .= '    <a href="delete.php?id=' . h($r["id"]) . '" ';
            $view .= '       class="btn btn-danger btn-sm" ';
            $view .= '       onclick="return confirm(\'本当に削除しますか？\')">';
            $view .= '      削除';
            $view .= '    </a>';
        }
        
        $view .= '  </div>';
        $view .= '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ一覧 | PHP03 ユーザー認証システム</title>
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
    <h1 class="page-title">アンケート一覧</h1>

    <!-- -----------------------------------------
         管理者専用エリア
         管理者のみ表示される
         ----------------------------------------- -->
    <?php if ($_SESSION["kanri_flg"] == 1): ?>
        <div class="admin-only">
            <div class="admin-only-title">管理者メニュー</div>
            <p class="text-muted">管理者は全てのデータを削除できます。</p>
        </div>
    <?php endif; ?>

    <!-- -----------------------------------------
         一覧表示エリア
         PHPで生成した $view を出力
         ----------------------------------------- -->
    <div class="card">
        <?php if ($view): ?>
            <?= $view ?>
        <?php else: ?>
            <p class="text-muted text-center">まだデータがありません。</p>
        <?php endif; ?>
    </div>

    <!-- -----------------------------------------
         新規登録へのリンク
         ----------------------------------------- -->
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">新規登録する</a>
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


<?php
// ===========================================
// データ一覧表示（select.php）
// ===========================================
// このファイルはDBから全データを取得して
// 一覧表示します。編集・削除へのリンクも含みます。
// ===========================================


// -----------------------------------------
// 1. 共通関数ファイルを読み込み、DB接続
// -----------------------------------------
include("funcs.php");
$pdo = db_conn();


// -----------------------------------------
// 2. SELECT文を作成・実行
// -----------------------------------------
// ★ ORDER BY indate DESC で新しい順に取得
// -----------------------------------------
$sql = "xxxxxxxxxxxxxxxxxxxxxxx";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


// -----------------------------------------
// 3. データ表示用のHTML文字列を生成
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
        
        // ★ 編集ボタン
        // $view .= '    <a href="detail.php?id=' . h($r["id"]) . '" class="btn btn-secondary btn-sm">編集</a>';
        
        // ★ 削除ボタン
        // $view .= '    <a href="delete.php?id=' . h($r["id"]) . '" class="btn btn-danger btn-sm">';
        // $view .= '      削除';
        // $view .= '    </a>';
        
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
    <title>データ一覧 | PHP CRUD サンプル</title>
    <!-- 自作CSSを読み込み -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===========================================
     ナビゲーション
     =========================================== -->
<nav class="navbar">
    <a class="navbar-brand" href="index.php">PHP CRUD サンプル</a>
    <div class="navbar-links">
        <a href="index.php">新規登録</a>
        <a href="select.php">データ一覧</a>
    </div>
</nav>

<!-- ===========================================
     メインコンテンツ
     =========================================== -->
<div class="container">
    <h1 class="page-title">アンケート一覧</h1>

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
    <p>PHP CRUD サンプル - データベース連携の学習用</p>
</footer>

</body>
</html>


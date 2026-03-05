<?php
// ===========================================
// SQLインジェクション検証用（sql_injection.php）
// ===========================================
// 【警告】このファイルは学習目的のみです！
// 本番環境では絶対に使用しないでください。
// bindValue を使わない危険なコードの例です。
// ===========================================


// -----------------------------------------
// エラー表示設定（開発時のみ）
// -----------------------------------------
ini_set('display_errors', 'On');
error_reporting(E_ALL);


// -----------------------------------------
// 結果表示用変数
// -----------------------------------------
$view = '';
$executed_sql = '';


// -----------------------------------------
// POST通信の場合のみ実行
// -----------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // -----------------------------------------
    // 1. POSTデータを取得
    // -----------------------------------------
    $id = $_POST['id'];

    // -----------------------------------------
    // 2. DB接続
    // -----------------------------------------
    try {
        $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DB Connection Error: ' . $e->getMessage());
    }

    // -----------------------------------------
    // 3. 【危険】bindしていないSQL文
    // -----------------------------------------
    // ユーザー入力を直接SQL文に連結している
    // これがSQLインジェクションの脆弱性！
    // -----------------------------------------
    $sql = "SELECT * FROM gs_an_table WHERE id=" . $id;
    $executed_sql = $sql;  // 実行されるSQLを表示用に保存

    // 安全な書き方（コメントアウト）
    // $sql = "SELECT * FROM gs_an_table WHERE id = :id";
    // $stmt = $pdo->prepare($sql);
    // $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();

    // -----------------------------------------
    // 4. 結果表示
    // -----------------------------------------
    if ($status == false) {
        $error = $stmt->errorInfo();
        $view = '<div class="alert alert-error">SQL Error: ' . $error[2] . '</div>';
    } else {
        while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $view .= '<tr>';
            $view .= '<td>' . htmlspecialchars($res['id']) . '</td>';
            $view .= '<td>' . htmlspecialchars($res['name']) . '</td>';
            $view .= '<td>' . htmlspecialchars($res['email']) . '</td>';
            $view .= '</tr>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQLインジェクション検証 | PHP CRUD サンプル</title>
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
    <h1 class="page-title">SQLインジェクション検証</h1>

    <!-- -----------------------------------------
         警告メッセージ
         ----------------------------------------- -->
    <div class="warning-box">
        <h3>⚠️ 警告：学習目的のみ</h3>
        <p>
            このページは <strong>bindValue() を使わない危険なコード</strong> の例です。<br>
            本番環境では絶対にこのようなコードを使用しないでください！
        </p>
    </div>

    <!-- -----------------------------------------
         検索フォーム
         ----------------------------------------- -->
    <div class="card">
        <h2 class="card-title">ID検索</h2>
        
        <form method="POST" action="sql_injection.php">
            <div class="form-group">
                <label for="id">検索するID</label>
                <input type="text" name="id" id="id" 
                       placeholder="数字を入力... または攻撃コードを試す">
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>

        <!-- -----------------------------------------
             攻撃の試し方
             ----------------------------------------- -->
        <div class="mt-4">
            <p class="text-muted"><strong>攻撃の試し方：</strong></p>
            <ul class="text-muted" style="margin-left: 20px; font-size: 14px;">
                <li>正常: <code>1</code> → ID=1のデータのみ表示</li>
                <li>攻撃: <code>1 OR 'a' = 'a'</code> → 全データが表示される！</li>
            </ul>
        </div>
    </div>

    <!-- -----------------------------------------
         実行されたSQL文の表示
         ----------------------------------------- -->
    <?php if ($executed_sql): ?>
    <div class="card">
        <h2 class="card-title">実行されたSQL文</h2>
        <div class="code-block">
            <?= htmlspecialchars($executed_sql) ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- -----------------------------------------
         検索結果の表示
         ----------------------------------------- -->
    <?php if ($view): ?>
    <div class="card">
        <h2 class="card-title">検索結果</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>メール</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $view ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- ===========================================
     フッター
     =========================================== -->
<footer class="footer">
    <p>PHP CRUD サンプル - データベース連携の学習用</p>
</footer>

</body>
</html>


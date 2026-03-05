<?php
// ===========================================
// パスワードハッシュ化スクリプト（hash.php）
// ===========================================
// このファイルはパスワードのハッシュ化を行います。
// 
// 【使い方】
// 1. まずDBにユーザーを平文パスワードで登録
// 2. このファイルにブラウザでアクセス
// 3. 「ハッシュ化実行」ボタンをクリック
// 4. パスワードがハッシュ化されてDBに保存される
// 
// ※本番環境では削除すること！
// ===========================================

// -----------------------------------------
// 共通関数ファイルを読み込み
// -----------------------------------------
include("funcs.php");


// -----------------------------------------
// ハッシュ化処理
// -----------------------------------------
$message = "";
$results = [];

if (isset($_POST["action"]) && $_POST["action"] == "hash") {
    $pdo = db_conn();
    
    // 全ユーザーを取得
    $stmt = $pdo->prepare("SELECT * FROM gs_user_table");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        // すでにハッシュ化されているかチェック
        // password_hash で生成されたハッシュは '$2y$' で始まる
        if (strpos($user['lpw'], '$2y$') !== 0) {
            // ハッシュ化されていない場合、ハッシュ化を実行
            $hashed_password = password_hash($user['lpw'], PASSWORD_DEFAULT);
            
            // DBを更新
            $update_stmt = $pdo->prepare("UPDATE gs_user_table SET lpw = :lpw WHERE id = :id");
            $update_stmt->bindValue(':lpw', $hashed_password, PDO::PARAM_STR);
            $update_stmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
            $update_stmt->execute();
            
            $results[] = [
                'lid' => $user['lid'],
                'name' => $user['name'],
                'status' => 'ハッシュ化完了',
                'old_pw' => $user['lpw'],
                'new_pw' => substr($hashed_password, 0, 30) . '...'
            ];
        } else {
            $results[] = [
                'lid' => $user['lid'],
                'name' => $user['name'],
                'status' => 'すでにハッシュ化済み',
                'old_pw' => '-',
                'new_pw' => '-'
            ];
        }
    }
    
    $message = "処理が完了しました！";
}


// -----------------------------------------
// ハッシュ化のデモ表示
// -----------------------------------------
$demo_password = "test123";
$demo_hash = password_hash($demo_password, PASSWORD_DEFAULT);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワードハッシュ化 | PHP03</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1 class="page-title">パスワードハッシュ化ツール</h1>
    
    <!-- 警告メッセージ -->
    <div class="alert alert-warning">
        <strong>⚠️ 注意:</strong> このファイルは開発・学習用です。本番環境では必ず削除してください。
    </div>
    
    <!-- ハッシュ化の説明 -->
    <div class="card">
        <h2 class="card-title">パスワードハッシュ化とは？</h2>
        <p>パスワードを暗号化して保存することで、データベースが漏洩しても元のパスワードを復元できないようにします。</p>
        
        <h3 style="margin-top: 20px; font-size: 16px;">デモ: "<?= $demo_password ?>" をハッシュ化</h3>
        <div class="code-block">
            <code><?= $demo_hash ?></code>
        </div>
        
        <p class="text-muted">
            ※同じパスワードでも、実行するたびに異なるハッシュ値が生成されます。<br>
            ※これは「ソルト（salt）」という仕組みによるものです。
        </p>
    </div>
    
    <!-- ハッシュ化実行フォーム -->
    <div class="card">
        <h2 class="card-title">データベースのパスワードをハッシュ化</h2>
        <p>gs_user_table の全ユーザーのパスワードをハッシュ化します。</p>
        
        <form method="POST">
            <input type="hidden" name="action" value="hash">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary" onclick="return confirm('パスワードをハッシュ化しますか？')">
                    ハッシュ化を実行
                </button>
                <a href="login.php" class="btn btn-secondary">ログイン画面へ</a>
            </div>
        </form>
    </div>
    
    <!-- 処理結果 -->
    <?php if ($message): ?>
        <div class="alert alert-success"><?= h($message) ?></div>
        
        <div class="card">
            <h2 class="card-title">処理結果</h2>
            <table>
                <thead>
                    <tr>
                        <th>ログインID</th>
                        <th>ユーザー名</th>
                        <th>ステータス</th>
                        <th>元のパスワード</th>
                        <th>新しいハッシュ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $r): ?>
                        <tr>
                            <td><?= h($r['lid']) ?></td>
                            <td><?= h($r['name']) ?></td>
                            <td><?= h($r['status']) ?></td>
                            <td><?= h($r['old_pw']) ?></td>
                            <td style="font-family: monospace; font-size: 12px;"><?= h($r['new_pw']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <!-- PHPコード例 -->
    <div class="card">
        <h2 class="card-title">PHPでのハッシュ化コード例</h2>
        
        <h3 style="font-size: 14px; margin-bottom: 10px;">パスワードをハッシュ化:</h3>
        <div class="code-block">
            <code>$hashed = password_hash($password, PASSWORD_DEFAULT);</code>
        </div>
        
        <h3 style="font-size: 14px; margin-bottom: 10px; margin-top: 20px;">パスワードを検証:</h3>
        <div class="code-block">
            <code>if (password_verify($input_password, $hashed_password)) {<br>
    // ログイン成功<br>
}</code>
        </div>
    </div>
</div>

<footer class="footer">
    <p>PHP03 ユーザー認証システム - パスワードハッシュ化ツール</p>
</footer>

</body>
</html>


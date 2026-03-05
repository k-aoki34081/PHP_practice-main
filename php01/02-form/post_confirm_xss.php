<?php
// ===========================================
// POSTデータの受信
// ===========================================

// $_POST["name属性"] でフォームの値を取得
// name, email を取得して $name, $email に代入してみよう

$name = $_POST["name"];
$email = $_POST["email"];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>送信内容確認</title>
</head>
<body>
    <h1>POSTフォームの送信内容確認 - XSS対策</h1>
    
    <p>以下の内容で受け付けました。</p>
    
    <ul>
        <!-- htmlspecialchars($value, ENT_QUOTES, 'UTF-8') -->
        <li>お名前: <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></li>
        <li>メール: <?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></li>
    </ul>
    
    <hr>
    <p>※ URLを確認してください。GET とは違い、データが表示されていません。</p>
    
    <p><a href="post.php">← 戻る</a></p>
</body>
</html>

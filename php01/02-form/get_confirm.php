<?php
// ===========================================
// GETデータの受信
// ===========================================

// $_GET["name属性"] でフォームの値を取得
// name, email を取得して $name, $email に代入してみよう

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>確認画面</title>
</head>
<body>
    <h1>GETフォームの送信内容確認</h1>
    
    <ul>
        <!-- <?= $name ?> は <?php echo $name ?> の省略形 -->
        <li>お名前: <?= $name ?></li>
        <li>メール: <?= $email ?></li>
    </ul>
    
    <hr>
    <p>※ URLを確認してください。データが表示されています。</p>
    
    <p><a href="get.php">← 戻る</a></p>
</body>
</html>

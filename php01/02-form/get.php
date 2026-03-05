<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>GETフォーム</title>
</head>
<body>
    <h1>GETフォーム</h1>
    
    <!-- 
        action: 送信先のファイル
        method: get（URLにデータが表示される）
    -->
    <!-- action を設定してみよう -->
    <form action="" method="get">
        <p>
            <label>お名前:</label><br>
            <input type="text" name="name">
        </p>
        <p>
            <label>メール:</label><br>
            <input type="email" name="email">
        </p>
        <p>
            <input type="submit" value="検索する">
        </p>
    </form>
    
</body>
</html>

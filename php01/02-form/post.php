<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>POSTフォーム</title>
</head>
<body>
    <h1>POSTフォーム</h1>
    
    <!-- 
        action: 送信先のファイル
        method: post（URLにデータが表示されない）
    -->
    <!-- action を設定してみよう -->
    <form action="" method="post">
        <p>
            <label>お名前:</label><br>
            <input type="text" name="name">
        </p>
        <p>
            <label>メール:</label><br>
            <input type="email" name="email">
        </p>
        <p>
            <input type="submit" value="送信する">
        </p>
    </form>
    
</body>
</html>

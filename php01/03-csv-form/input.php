<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アンケート入力</title>
</head>
<body>
    <h1>アンケート入力</h1>
    
    <form action="confirm.php" method="post">
        <p>
            <label>お名前:</label><br>
            <input type="text" name="name">
        </p>
        <p>
            <label>メールアドレス:</label><br>
            <input type="email" name="email">
        </p>
        <p>
            <label>ご意見・ご感想:</label><br>
            <input type="text" name="comment" size="40">
        </p>
        <p>
            <input type="submit" value="送信する">
        </p>
    </form>
    
    <hr>
    <p><a href="list.php">回答一覧を見る</a></p>
</body>
</html>


<?php
// ===========================================
// ユーザー登録処理（register_act.php）
// ===========================================
// このファイルは register.php のフォームから
// POSTで送信されたデータでユーザー登録を行います。
// ===========================================


// -----------------------------------------
// 1. POSTデータを取得
// -----------------------------------------
$name     = $_POST["name"];
$email    = $_POST["email"];
$password = $_POST["password"];


// -----------------------------------------
// 2. 共通関数ファイルを読み込み、DB接続
// -----------------------------------------
include("funcs.php");
$pdo = db_conn();


// -----------------------------------------
// TODO: 3. パスワードをハッシュ化
//  password_hash() というPHPに最初から用意されている関数を使うと、
// 「二度と元の文字に戻せない安全な文字列（ハッシュ）」に自動で
// 変換してくれます。 
// -----------------------------------------
// php03 の hash.php の 41行目付近を見てみよう！
// -----------------------------------------
/* ↓↓↓ ここにコードを追加 ↓↓↓ */
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
/* ↑↑↑ ここまで ↑↑↑ */
// PASSWORD_DEFAULTは、「今のPHPが推奨している、一番安全な暗号化ルール（アルゴリズム）を自動的に使ってね」という指定（設定値）


// -----------------------------------------
// TODO: 4. INSERT文を作成・実行
// -----------------------------------------
// users テーブルに新しいユーザーを登録しよう
// INSERT INTO テーブル名 (カラム名1, カラム名2, カラム名3) VALUES (:name, :email, :password, NOW())
// php02 の insert.php を参考に！
// -----------------------------------------
/* ↓↓↓ ここにSQLを書く ↓↓↓ */
$sql = "INSERT INTO users(name, email, password, created_at) VALUES(:name, :email, :password, NOW())";
/* ↑↑↑ ここまで ↑↑↑ */
// (name, email, password, created_at)は、usersというテーブルに入れるカラム（項目の列）
// ここにどんな値をいれるか定義しているのが、VALUES(:name, :email, :password, NOW()) ※ NOW() （現在時刻を取得するSQLの機能）

$stmt = $pdo->prepare($sql);

// bindValue()でプレースホルダーに値をバインド
$stmt->bindValue(':name',     $name,            PDO::PARAM_STR);
$stmt->bindValue(':email',    $email,           PDO::PARAM_STR);
$stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);

$status = $stmt->execute();


// -----------------------------------------
// 5. 実行結果の判定とリダイレクト
// -----------------------------------------
if ($status == false) {
    sql_error($stmt);
} else {
    // 成功時はログイン画面にリダイレクト
    redirect("login.php");
}


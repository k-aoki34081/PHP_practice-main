# PHP課題：掲示板アプリ

## 概要

この課題では、PHPで「簡易掲示板アプリ」を完成させます。  
php01〜php03で学んだ内容を活かして、穴埋め形式でコードを書いていきましょう。

## 機能

- **ユーザー登録**: 新規アカウントの作成
- **ログイン/ログアウト**: セッションを使った認証
- **投稿の作成（Create）**: 新しい投稿を追加
- **投稿の一覧表示（Read）**: 全投稿を新しい順に表示
- **投稿の編集（Update）**: 自分の投稿を編集
- **投稿の削除（Delete）**: 自分の投稿を削除

## セットアップ手順

### 1. データベースの作成

1. phpMyAdminを開く
2. 「SQL」タブをクリック
3. `SQL/board_setup.sql` の内容をコピー＆ペースト
4. 「実行」をクリック

### 2. ファイルの配置

このフォルダを XAMPP/MAMP の htdocs 直下に配置してください。

```
htdocs/
└── php_kadai/
    ├── SQL/
    ├── css/
    ├── funcs.php
    ├── login.php
    └── ...
```

### 3. ブラウザでアクセス

```
http://localhost/php_kadai/login.php
```

## 穴埋め箇所

以下のファイルに穴埋め箇所があります。  
`/* ↓↓↓ ここにコードを追加 ↓↓↓ */` と `/* ↑↑↑ ここまで ↑↑↑ */` の間にコードを書いてください。

| ファイル | 穴埋め内容 |
|---------|----------|
| `funcs.php` | セッションチェック関数の実装 |
| `login_act.php` | ログイン処理 |
| `logout.php` | ログアウト処理 |
| `register_act.php` | ユーザー登録処理 |
| `index.php` | 投稿一覧の取得・表示 |
| `create_act.php` | 投稿の作成処理 |
| `edit.php` | 投稿データの取得・権限チェック |
| `update_act.php` | 投稿の更新処理 |
| `delete.php` | 投稿の削除処理 |

## テストアカウント

SQLを実行すると、以下のテストアカウントが作成されます。

- **Email**: `test@example.com`
- **Password**: `test123`

## ヒント

### セッション関連
- `session_start()` はPHPファイルの最初に書く
- `$_SESSION["xxx"]` でセッション変数にアクセス
- `session_destroy()` でセッションを破棄

### POSTデータの取得
- `$_POST["name"]` でフォームのname属性の値を取得

### GETデータの取得
- `$_GET["id"]` でURLパラメータ（?id=1）を取得

### パスワード関連
- `password_hash($pw, PASSWORD_DEFAULT)` でハッシュ化
- `password_verify($pw, $hash)` で検証

### SQL関連
- `prepare()` でSQL文を準備
- `bindValue()` でプレースホルダーに値をバインド
- `execute()` でSQLを実行
- `fetch()` で1件取得

### 参考
- php02の各ファイル（SELECT, INSERT, UPDATE, DELETE）
- php03のlogin_act.php（認証処理）

頑張ってください！


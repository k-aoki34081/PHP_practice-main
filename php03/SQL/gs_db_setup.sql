-- ===========================================
-- gs_db_login データベースセットアップSQL
-- ===========================================
-- PHP03 ユーザー認証システム用
-- 
-- ※このSQLはphpMyAdminの「SQL」タブで実行してください
-- ※既にgs_db_loginデータベースが存在する場合は、
--   テーブル作成部分のみを実行してください
-- ===========================================


-- -----------------------------------------
-- 1. データベースの作成（存在しない場合）
-- -----------------------------------------
CREATE DATABASE IF NOT EXISTS gs_db_login
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE gs_db_login;


-- ===========================================
-- アンケートテーブル（gs_an_table）
-- ===========================================
-- php02から引き継ぐテーブル
-- -----------------------------------------
CREATE TABLE IF NOT EXISTS gs_an_table (
    id      INT(12)      NOT NULL AUTO_INCREMENT,
    name    VARCHAR(64)  NOT NULL,
    email   VARCHAR(256) NOT NULL,
    naiyou  TEXT         DEFAULT NULL,
    indate  DATETIME     NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -----------------------------------------
-- サンプルデータの挿入（アンケート）
-- -----------------------------------------
INSERT INTO gs_an_table (name, email, naiyou, indate) VALUES
('山田太郎', 'yamada@example.com', 'とても勉強になりました！', NOW()),
('佐藤花子', 'sato@example.com', '分かりやすい説明でした。', NOW()),
('田中次郎', 'tanaka@example.com', 'もう少し詳しく知りたいです。', NOW());


-- ===========================================
-- ユーザーテーブル（gs_user_table）
-- ===========================================
-- ログイン認証用のテーブル
-- -----------------------------------------
-- id: 主キー（自動採番）
-- name: ユーザー名（表示用）
-- lid: ログインID（メールアドレス形式推奨）
-- lpw: パスワード（ハッシュ化して保存）
-- kanri_flg: 管理者フラグ（0=一般, 1=管理者）
-- life_flg: 有効フラグ（0=有効, 1=無効）
-- indate: 登録日時
-- ===========================================
CREATE TABLE IF NOT EXISTS gs_user_table (
    id        INT(12)      NOT NULL AUTO_INCREMENT,
    name      VARCHAR(64)  NOT NULL COMMENT 'ユーザー名',
    lid       VARCHAR(128) NOT NULL COMMENT 'ログインID',
    lpw       VARCHAR(255) NOT NULL COMMENT 'パスワード（ハッシュ）',
    kanri_flg INT(1)       NOT NULL DEFAULT 0 COMMENT '管理者フラグ(0:一般,1:管理者)',
    life_flg  INT(1)       NOT NULL DEFAULT 0 COMMENT '有効フラグ(0:有効,1:無効)',
    indate    DATETIME     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY lid (lid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ===========================================
-- ユーザーサンプルデータの挿入
-- ===========================================
-- ※最初は平文パスワードで挿入
-- ※hash.phpを実行してハッシュ化する
-- -----------------------------------------
-- 管理者ユーザー: admin / admin123
-- 一般ユーザー1: user1 / user123
-- 一般ユーザー2: user2 / user123
-- -----------------------------------------
INSERT INTO gs_user_table (name, lid, lpw, kanri_flg, life_flg, indate) VALUES
('管理者', 'admin', 'admin123', 1, 0, NOW()),
('山田太郎', 'user1', 'user123', 0, 0, NOW()),
('佐藤花子', 'user2', 'user123', 0, 0, NOW());


-- ===========================================
-- 【参考】よく使うSQLコマンド
-- ===========================================

-- ユーザー一覧取得
-- SELECT * FROM gs_user_table;

-- 特定ユーザーの検索（ログインIDで）
-- SELECT * FROM gs_user_table WHERE lid = 'admin';

-- パスワード更新（ハッシュ化後）
-- UPDATE gs_user_table SET lpw = 'ハッシュ値' WHERE lid = 'admin';

-- ユーザー削除（論理削除）
-- UPDATE gs_user_table SET life_flg = 1 WHERE id = 1;

-- テーブル構造の確認
-- DESCRIBE gs_user_table;


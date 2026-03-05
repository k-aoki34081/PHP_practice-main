-- ===========================================
-- gs_an_table テーブル作成SQL
-- ===========================================
-- データベース名: gs_db
-- テーブル名: gs_an_table
-- 用途: アンケートデータの保存
-- ===========================================

-- -----------------------------------------
-- 1. データベースの作成（存在しない場合）
-- -----------------------------------------
-- phpMyAdmin で手動作成する場合は不要
-- 照合順序: utf8mb4_unicode_ci を推奨
-- -----------------------------------------
-- CREATE DATABASE IF NOT EXISTS gs_db
-- DEFAULT CHARACTER SET utf8mb4
-- COLLATE utf8mb4_unicode_ci;

-- USE gs_db;


-- -----------------------------------------
-- 2. テーブルの作成
-- -----------------------------------------
-- id: 主キー（自動採番）
-- name: 回答者の名前
-- email: メールアドレス
-- naiyou: アンケート内容
-- indate: 登録日時
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
-- 3. サンプルデータの挿入（任意）
-- -----------------------------------------
-- 動作確認用のテストデータ
-- -----------------------------------------
INSERT INTO gs_an_table (name, email, naiyou, indate) VALUES
('山田太郎', 'yamada@example.com', 'とても勉強になりました！', NOW()),
('佐藤花子', 'sato@example.com', '分かりやすい説明でした。', NOW()),
('田中次郎', 'tanaka@example.com', 'もう少し詳しく知りたいです。', NOW());


-- ===========================================
-- 【補足】よく使うSQLコマンド
-- ===========================================

-- 全データ取得
-- SELECT * FROM gs_an_table;

-- 特定IDのデータ取得
-- SELECT * FROM gs_an_table WHERE id = 1;

-- データの挿入
-- INSERT INTO gs_an_table (name, email, naiyou, indate)
-- VALUES ('名前', 'email@example.com', '内容', NOW());

-- データの更新
-- UPDATE gs_an_table SET name = '新しい名前' WHERE id = 1;

-- データの削除
-- DELETE FROM gs_an_table WHERE id = 1;

-- テーブル構造の確認
-- DESCRIBE gs_an_table;

-- テーブルの削除（注意！）
-- DROP TABLE gs_an_table;


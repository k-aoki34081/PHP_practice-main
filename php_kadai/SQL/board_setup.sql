-- ===========================================
-- 掲示板アプリ データベースセットアップSQL
-- ===========================================
-- PHP課題用 - 簡易掲示板アプリ
-- 
-- ※このSQLはphpMyAdminの「SQL」タブで実行してください
-- ===========================================


-- -----------------------------------------
-- 1. データベースの作成（存在しない場合）
-- -----------------------------------------
CREATE DATABASE IF NOT EXISTS board_db
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE board_db;


-- ===========================================
-- ユーザーテーブル（users）
-- ===========================================
-- ユーザー情報を保存するテーブル
-- -----------------------------------------
-- id: 主キー（自動採番）
-- name: ユーザー名（表示用）
-- email: メールアドレス（ログインID）
-- password: パスワード（ハッシュ化して保存）
-- created_at: 登録日時
-- ===========================================
CREATE TABLE IF NOT EXISTS users (
    id         INT(12)      NOT NULL AUTO_INCREMENT,
    name       VARCHAR(64)  NOT NULL COMMENT 'ユーザー名',
    email      VARCHAR(256) NOT NULL COMMENT 'メールアドレス',
    password   VARCHAR(255) NOT NULL COMMENT 'パスワード（ハッシュ）',
    created_at DATETIME     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ===========================================
-- 投稿テーブル（posts）
-- ===========================================
-- 掲示板の投稿を保存するテーブル
-- -----------------------------------------
-- id: 主キー（自動採番）
-- user_id: 投稿者のユーザーID
-- content: 投稿内容
-- created_at: 投稿日時
-- ===========================================
CREATE TABLE IF NOT EXISTS posts (
    id         INT(12)  NOT NULL AUTO_INCREMENT,
    user_id    INT(12)  NOT NULL COMMENT '投稿者ID',
    content    TEXT     NOT NULL COMMENT '投稿内容',
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ===========================================
-- サンプルデータの挿入
-- ===========================================
-- ※パスワードは password_hash() でハッシュ化済み
-- ※元のパスワード: test123
-- ===========================================

-- サンプルユーザー（パスワード: test123）
INSERT INTO users (name, email, password, created_at) VALUES
('テストユーザー', 'test@example.com', '$2y$10$fDp0FrdGE2O4Wo2AhbE2DOWwKtV9N5gT8j2Q4flsoSLLj86DE8lCK', NOW()),
('山田太郎', 'yamada@example.com', '$2y$10$fDp0FrdGE2O4Wo2AhbE2DOWwKtV9N5gT8j2Q4flsoSLLj86DE8lCK', NOW());

-- サンプル投稿
INSERT INTO posts (user_id, content, created_at) VALUES
(1, 'はじめまして！テスト投稿です。', NOW()),
(2, 'こんにちは、山田です。よろしくお願いします！', NOW()),
(1, 'PHPの勉強を頑張っています。', NOW());


-- ===========================================
-- 【参考】よく使うSQLコマンド
-- ===========================================

-- ユーザー一覧取得
-- SELECT * FROM users;

-- 投稿一覧取得（ユーザー名付き）
-- SELECT posts.*, users.name 
-- FROM posts 
-- JOIN users ON posts.user_id = users.id 
-- ORDER BY posts.created_at DESC;

-- 特定ユーザーの投稿取得
-- SELECT * FROM posts WHERE user_id = 1;

-- テーブル構造の確認
-- DESCRIBE users;
-- DESCRIBE posts;


-- ============================================
-- PHP04 データベース設計基礎
-- 【授業前にインポート】
-- ============================================

CREATE DATABASE IF NOT EXISTS join_sample CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE join_sample;

-- 学生テーブル
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    email VARCHAR(256) UNIQUE NOT NULL,
    phone VARCHAR(32)
);

-- 講師テーブル
CREATE TABLE IF NOT EXISTS instructors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    email VARCHAR(256) UNIQUE NOT NULL
);

-- コーステーブル
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    instructor_id INT NOT NULL,
    fee INT NOT NULL,
    FOREIGN KEY (instructor_id) REFERENCES instructors(id)
);

-- 受講テーブル（学生とコースの関連）
CREATE TABLE IF NOT EXISTS enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- 学生データ
INSERT INTO students (name, email, phone) VALUES 
('田中太郎', 'tanaka@example.com', '090-1234-5678'),
('佐藤花子', 'sato@example.com', '080-9876-5432'),
('鈴木一郎', 'suzuki@example.com', '070-1111-2222');

-- 講師データ
INSERT INTO instructors (name, email) VALUES 
('佐藤先生', 'sato@school.com'),
('田中先生', 'tanaka@school.com');

-- コースデータ
INSERT INTO courses (name, instructor_id, fee) VALUES 
('PHP基礎', 1, 50000),
('JavaScript基礎', 2, 45000),
('React応用', 1, 60000);

-- 受講データ
INSERT INTO enrollments (student_id, course_id, enrollment_date) VALUES 
(1, 1, '2024-01-15'),  -- 田中太郎がPHP基礎を受講
(2, 2, '2024-01-16'),  -- 佐藤花子がJavaScript基礎を受講
(1, 3, '2024-01-17'),  -- 田中太郎がReact応用を受講
(3, 1, '2024-01-18'),  -- 鈴木一郎がPHP基礎を受講
(1, 2, '2024-01-20');  -- 田中太郎がJavaScript基礎を受講

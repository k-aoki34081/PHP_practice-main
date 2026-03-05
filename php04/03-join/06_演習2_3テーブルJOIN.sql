-- ============================================
-- 演習2: 3つのテーブルをJOIN
-- ============================================

USE join_sample;

-- 学生名と受講コース名を一緒に表示
SELECT
    s.name AS 学生名,
    s.email AS メールアドレス,
    c.name AS 受講コース,
    e.enrollment_date AS 受講開始日
FROM enrollments e
INNER JOIN students s ON e.student_id = s.id
INNER JOIN courses c ON e.course_id = c.id
ORDER BY e.enrollment_date;

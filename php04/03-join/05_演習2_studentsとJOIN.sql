-- ============================================
-- 演習2: studentsテーブルと結合
-- ============================================

USE join_sample;

-- 学生情報を結合
SELECT 
    e.id,
    s.name AS 学生名,
    e.course_id,
    e.enrollment_date
FROM enrollments e
INNER JOIN students s ON e.student_id = s.id
ORDER BY e.enrollment_date;

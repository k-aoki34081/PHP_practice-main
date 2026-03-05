-- ============================================
-- 演習3: 4つのテーブルをすべてJOIN
-- ============================================

USE join_sample;

-- 受講に関する全ての情報を表示
SELECT
    s.name AS 学生名,
    c.name AS コース名,
    i.name AS 担当講師,
    c.fee AS 受講料,
    e.enrollment_date AS 受講開始日
FROM enrollments e
INNER JOIN students s ON e.student_id = s.id
INNER JOIN courses c ON e.course_id = c.id
INNER JOIN instructors i ON c.instructor_id = i.id
ORDER BY e.enrollment_date;

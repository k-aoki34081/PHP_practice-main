-- ============================================
-- 演習2: enrollmentsテーブル単体
-- ============================================

USE join_sample;

-- 受講テーブルの確認
SELECT 
    id,
    student_id,
    course_id,
    enrollment_date
FROM enrollments
ORDER BY enrollment_date;

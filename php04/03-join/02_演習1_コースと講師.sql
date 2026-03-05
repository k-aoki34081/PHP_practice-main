-- ============================================
-- 演習1: コースと講師を結合して表示
-- ============================================

USE join_sample;

-- Step 1: coursesテーブル単体
SELECT 
    name AS コース名,
    fee AS 受講料,
    instructor_id AS 担当講師ID
FROM courses;

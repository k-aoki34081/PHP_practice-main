-- ============================================
-- 演習1: INNER JOINで講師テーブルと結合
-- ============================================

USE join_sample;

-- コース名と担当講師名を一緒に表示
SELECT
    c.name AS コース名,
    c.fee AS 受講料,
    i.name AS 担当講師
FROM courses c
INNER JOIN instructors i ON c.instructor_id = i.id;

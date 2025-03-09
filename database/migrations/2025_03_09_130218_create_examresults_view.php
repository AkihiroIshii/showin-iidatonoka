<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW examresults_view AS
            SELECT
                tr.id as id,
                schools.name as school_name,
                users.name,
                te.year,
                te.grade,
                te.exam_date,
                te.exam_name,
                te.avg_japanese,
                te.avg_math,
                te.avg_science,
                te.avg_english,
                tr.score_japanese,
                tr.score_math,
                tr.score_english,
                pe.exam_date as previous_date,
                pe.exam_name as previous_name,
                tr.memo,
                (tr.score_japanese + tr.score_society + tr.score_math + tr.score_science + tr.score_english) as sum_score,
                (te.avg_japanese + te.avg_society + te.avg_math + te.avg_science + te.avg_english) as sum_avg,
                CONCAT(
                    CASE WHEN tr.score_japanese - te.avg_japanese >= 0 THEN '+' ELSE '' END,
                    ROUND(tr.score_japanese - te.avg_japanese, 1)
                ) as avg_diff_japanese,
                CONCAT(
                    CASE WHEN tr.score_society - te.avg_society >= 0 THEN '+' ELSE '' END,
                    ROUND(tr.score_society - te.avg_society, 1)
                ) as avg_diff_society,
                CONCAT(
                    CASE WHEN tr.score_math - te.avg_math >= 0 THEN '+' ELSE '' END,
                    ROUND(tr.score_math - te.avg_math, 1)
                ) as avg_diff_math,
                CONCAT(
                    CASE WHEN tr.score_science - te.avg_science >= 0 THEN '+' ELSE '' END,
                    ROUND(tr.score_science - te.avg_science, 1)
                ) as avg_diff_science,
                CONCAT(
                    CASE WHEN tr.score_english - te.avg_english >= 0 THEN '+' ELSE '' END,
                    ROUND(tr.score_english - te.avg_english, 1)
                ) as avg_diff_english,
                CONCAT(
                    CASE WHEN (tr.score_japanese + tr.score_society + tr.score_math + tr.score_science + tr.score_english) - (te.avg_japanese + te.avg_society + te.avg_math + te.avg_science + te.avg_english) >= 0 THEN '+' ELSE '' END,
                    ROUND((tr.score_japanese + tr.score_society + tr.score_math + tr.score_science + tr.score_english) - (te.avg_japanese + te.avg_society + te.avg_math + te.avg_science + te.avg_english), 1)
                ) as avg_diff_all,
                CONCAT(
                    CASE WHEN tr.score_japanese - pr.score_japanese >= 0 THEN '+' ELSE '' END,
                    tr.score_japanese - pr.score_japanese
                ) as prev_diff_japanese,
                CONCAT(
                    CASE WHEN tr.score_society - pr.score_society >= 0 THEN '+' ELSE '' END,
                    tr.score_society - pr.score_society
                ) as prev_diff_society,
                CONCAT(
                    CASE WHEN tr.score_math - pr.score_math >= 0 THEN '+' ELSE '' END,
                    tr.score_math - pr.score_math
                ) as prev_diff_math,
                CONCAT(
                    CASE WHEN tr.score_science - pr.score_science >= 0 THEN '+' ELSE '' END,
                    tr.score_science - pr.score_science
                ) as prev_diff_science,
                CONCAT(
                    CASE WHEN tr.score_english - pr.score_english >= 0 THEN '+' ELSE '' END,
                    tr.score_english - pr.score_english
                ) as prev_diff_english,
                CONCAT(
                    CASE WHEN (tr.score_japanese + tr.score_society + tr.score_math + tr.score_science + tr.score_english) - (pr.score_japanese + pr.score_society + pr.score_math + pr.score_science + pr.score_english) >= 0 THEN '+' ELSE '' END,
                    (tr.score_japanese + tr.score_society + tr.score_math + tr.score_science + tr.score_english) - (pr.score_japanese + pr.score_society + pr.score_math + pr.score_science + pr.score_english)
                ) as prev_diff_all
            FROM examresults as tr
            LEFT JOIN exams te ON tr.exam_id = te.id
            LEFT JOIN examresults as pr ON tr.user_id = pr.user_id
                AND pr.exam_id = (
                    SELECT exam_id FROM examresults
                    WHERE user_id = tr.user_id
                    AND exam_id IN (SELECT id FROM exams WHERE exam_date < te.exam_date) 
                    ORDER BY exam_id DESC 
                    LIMIT 1
                )
            LEFT JOIN exams as pe ON pr.exam_id = pe.id
            LEFT JOIN users ON tr.user_id = users.id
            LEFT JOIN schools ON te.school_id = schools.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS examresults_view");
    }
};

<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Exam;
use App\Models\Examresult;

trait ExamTrait
{
    public function getExamResults(User $user) {
        //生徒の学校におけるテストを取得（年度内で前回のテストもあれば結合）
        $exams = DB::table('exams as ex1')
            ->where('ex1.school_id', $user->school_id)
            ->leftJoin('schools', function($join) {
                $join->on('ex1.school_id', '=', 'schools.id');
            })
            ->leftJoin('exams as ex2', function($join) {
                $join->on('ex1.school_id', '=', 'ex2.school_id')
                    ->on('ex1.year', '=', 'ex2.year')
                    ->on('ex1.grade', '=', 'ex2.grade')
                    ->on('ex1.no', '=', DB::raw('ex2.no + 1'));
            })
            ->where('ex1.grade', '=', $user->grade)
            ->selectRaw('
                ex1.*,
                schools.name as schoolName,
                ex2.id
            ');

        //生徒の得点を取得
        $examresultsSub = Examresult::where('user_id', '=', $user->id);

        //生徒の点数を結合
        $examresults = $exams->leftjoinSub($examresultsSub, 'r1', function($join) {
            $join->on('ex1.id', '=', 'r1.exam_id');
        })
        ->leftjoinSub($examresultsSub, 'r2', function($join) {
            $join->on('ex2.id', '=', 'r2.exam_id');
        })
        ->selectRaw("
            ex1.*,
            r1.score_japanese,
            r1.score_society,
            r1.score_math,
            r1.score_science,
            r1.score_english,
            CONCAT(
                CASE WHEN r1.score_japanese - ex1.avg_japanese >= 0 THEN '+' ELSE '' END,
                ROUND(r1.score_japanese - ex1.avg_japanese, 1)
            ) as avg_diff_japanese,
            CONCAT(
                CASE WHEN r1.score_society - ex1.avg_society >= 0 THEN '+' ELSE '' END,
                ROUND(r1.score_society - ex1.avg_society, 1)
            ) as avg_diff_society,
            CONCAT(
                CASE WHEN r1.score_math - ex1.avg_math >= 0 THEN '+' ELSE '' END,
                ROUND(r1.score_math - ex1.avg_math, 1)
            ) as avg_diff_math,
            CONCAT(
                CASE WHEN r1.score_science - ex1.avg_science >= 0 THEN '+' ELSE '' END,
                ROUND(r1.score_science - ex1.avg_science, 1)
            ) as avg_diff_science,
            CONCAT(
                CASE WHEN r1.score_english - ex1.avg_english >= 0 THEN '+' ELSE '' END,
                ROUND(r1.score_english - ex1.avg_english, 1)
            ) as avg_diff_english,
            CONCAT(
                CASE WHEN r1.score_japanese - r2.score_japanese >= 0 THEN '+' ELSE '' END,
                r1.score_japanese - r2.score_japanese
            ) as prev_diff_japanese,
            CONCAT(
                CASE WHEN r1.score_society - r2.score_society >= 0 THEN '+' ELSE '' END,
                r1.score_society - r2.score_society
            ) as prev_diff_society,
            CONCAT(
                CASE WHEN r1.score_math - r2.score_math >= 0 THEN '+' ELSE '' END,
                r1.score_math - r2.score_math
            ) as prev_diff_math,
            CONCAT(
                CASE WHEN r1.score_science - r2.score_science >= 0 THEN '+' ELSE '' END,
                r1.score_science - r2.score_science
            ) as prev_diff_science,
            CONCAT(
                CASE WHEN r1.score_english - r2.score_english >= 0 THEN '+' ELSE '' END,
                r1.score_english - r2.score_english
            ) as prev_diff_english
        ")
        ->get();

        return $examresults;
    }
}

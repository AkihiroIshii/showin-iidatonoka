<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\School;
use App\Models\Exam;
use App\Models\ExamresultsView;

trait ExamresultTrait
{
    // public function getExamresultsWithAverage() {
    //     $user_ids = Arr::wrap(Session::get('target_students'));

    //     $examresults = ExamresultsView::whereIn('user_id', $user_ids)
    //     ->orderBy('exam_date', 'desc')
    //     ->get();

    //     return $examresults;
    // }

    public function getExamresultsWithAverage() {
        $user_ids = Arr::wrap(Session::get('target_students'));

        $examresults = DB::table('examresults as tr')
        ->leftJoin('exams as te', 'tr.exam_id', '=', 'te.id')
        ->leftJoin('examresults as pr', function ($join) {
            $join->on('tr.user_id', '=', 'pr.user_id')
                 ->whereRaw('pr.exam_id = (
                     SELECT exam_id FROM examresults
                     LEFT JOIN exams ON examresults.exam_id = exams.id 
                     WHERE user_id = tr.user_id 
                     AND exam_id IN (SELECT id FROM exams WHERE exam_date < te.exam_date)
                     AND exams.school_id != 902
                     ORDER BY exams.exam_date DESC 
                     LIMIT 1
                 )'); //なが模試（school_id = 902）は除く
                //  ->whereRaw('pr.exam_id = (
                //     SELECT exam_id FROM examresults 
                //     WHERE user_id = tr.user_id 
                //     AND exam_id IN (SELECT id FROM exams WHERE exam_date < te.exam_date) 
                //     ORDER BY exam_date DESC 
                //     LIMIT 1
                // )');
        })
        ->leftJoin('exams as pe', 'pr.exam_id', '=', 'pe.id')
        ->leftJoin('users', 'tr.user_id', '=', 'users.id')
        ->leftJoin('schools', 'te.school_id', '=', 'schools.id')
        ->whereIn('tr.user_id', $user_ids)
        ->where('te.school_id', '!=', 902) //なが模試は除く
        ->select(
            'tr.id as id',
            'schools.name as school_name',
            'tr.user_id',
            'users.name',
            'te.id as exam_id',
            'te.year',
            'te.grade',
            'te.exam_date',
            'te.exam_name',
            'te.avg_japanese',
            'te.avg_society',
            'te.avg_math',
            'te.avg_science',
            'te.avg_english',
            'tr.score_japanese',
            'tr.score_society',
            'tr.score_math',
            'tr.score_science',
            'tr.score_english',
            'pe.exam_date as previous_date',
            'pe.exam_name as previous_name'
        )
        ->selectRaw("
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
        ")
        ->orderBy('te.exam_date', 'desc')
        ->get();

        return $examresults;
    }

    // なが模試の結果一覧取得
    public function getMoshiresultsWithAverage() {
        $user_ids = Arr::wrap(Session::get('target_students'));

        $examresults = DB::table('examresults as tr')
        ->leftJoin('exams as te', 'tr.exam_id', '=', 'te.id')
        ->leftJoin('examresults as pr', function ($join) {
            $join->on('tr.user_id', '=', 'pr.user_id')
                 ->whereRaw('pr.exam_id = (
                     SELECT exam_id FROM examresults
                     LEFT JOIN exams ON examresults.exam_id = exams.id 
                     WHERE user_id = tr.user_id 
                     AND exam_id IN (SELECT id FROM exams WHERE exam_date < te.exam_date)
                     AND exams.school_id = 902
                     ORDER BY exams.exam_date DESC 
                     LIMIT 1
                 )'); //なが模試（school_id = 902）のみ
        })
        ->leftJoin('exams as pe', 'pr.exam_id', '=', 'pe.id')
        ->leftJoin('users', 'tr.user_id', '=', 'users.id')
        ->leftJoin('schools', 'te.school_id', '=', 'schools.id')
        ->whereIn('tr.user_id', $user_ids)
        ->where('te.school_id', '=', 902) //なが模試のみ
        ->select(
            'tr.id as id',
            'schools.name as school_name',
            'tr.user_id',
            'users.name',
            'te.id as exam_id',
            'te.year',
            'te.grade',
            'te.exam_date',
            'te.exam_name',
            'te.avg_japanese',
            'te.avg_society',
            'te.avg_math',
            'te.avg_science',
            'te.avg_english',
            'tr.score_japanese',
            'tr.score_society',
            'tr.score_math',
            'tr.score_science',
            'tr.score_english',
            'pe.exam_date as previous_date',
            'pe.exam_name as previous_name'
        )
        ->selectRaw("
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
        ")
        ->orderBy('te.exam_date', 'desc')
        ->get();

        return $examresults;
    }
}

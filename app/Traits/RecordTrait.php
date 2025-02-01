<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;
use App\Models\Target;
use App\Models\Question;

trait RecordTrait
{
    public function getRecords(User $user) {
        //問題
        $questions_sub = Question::query();

        //目標点数
        $targets = Target::where('user_id', $user->id);

        //演習記録
        $records = Record::leftjoinSub($questions_sub, 'questions_sub', function($join) {
                $join->on('records.question_id', '=', 'questions_sub.id');
            })->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions_sub.subject', '=', 'targets.subject')->on('questions_sub.no', '=', 'targets.no');
            })->where('records.user_id', $user->id)
            ->selectRaw('
                records.*,
                questions_sub.year, questions_sub.type, questions_sub.subject, questions_sub.no, questions_sub.point,
                targets.target_score, targets.target_minute,
                IF((target_score IS NOT NULL) AND (ROUND(100*score/target_score) >= 100), " (^^)/◎", "") as target_mark
                ')
            //並び替え
            ->orderBy('date','desc')
            ->orderBy('records.id','desc')
            ->get();

            return $records;
    }

    public function getSpreadsheetData(User $user) {
        //目標点数
        $targets = Target::where('user_id', $user->id);

        //演習記録（ユーザごと、大問ごとの集計値）
        $records_sub = Record::where('user_id', $user->id)
            ->select('user_id', 'question_id')
            ->selectRaw('
                COUNT(score) as count,
                MAX(score) as max_score,
                ROUND(AVG(score),0) as avg_score,
                MAX(date) as latest_date,
                ROUND(AVG(minute),0) as avg_minute
                ')
            ->groupBy('user_id','question_id');

        //大問にログインユーザの記録を紐づけ
        $questions = Question::where('year', '!=', '2019')
            ->leftjoinSub($records_sub, 'records_sub', function($join) {
                $join->on('questions.id', '=', 'records_sub.question_id');
            })
            //ログインユーザの目標点を紐づけ
            ->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
            })
            ->selectRaw('
                questions.*,
                records_sub.*,
                targets.target_score, targets.target_minute,
                IF(max_score IS NOT NULL, ROUND(100*max_score/point), "-") as score_rate,
                IF(ROUND(100*max_score/point) >= 80, " (^^)/◎", "") as max_mark,
                IF(max_score >= target_score, " (^^)/◎", "") as target_mark
            ')
            //並び替え
            ->orderBy('type','desc')
            ->orderBy('year','desc')
            ->orderBy('questions.subject','asc')
            ->orderBy('questions.no','asc')
            ->get();
            
        return $questions; 
    }

    // public function getSpreadsheet2Data(User $user) {
    //     //目標点数
    //     $targets = Target::where('user_id', $user->id);

    //     //演習記録（ユーザごと、大問ごとの集計値）
    //     $records_sub = Record::where('user_id', $user->id)
    //         ->select('user_id', 'question_id')
    //         ->selectRaw('
    //             COUNT(score) as count,
    //             MAX(score) as max_score,
    //             ROUND(AVG(score),0) as avg_score,
    //             MAX(date) as latest_date,
    //             ROUND(AVG(minute),0) as avg_minute
    //         ')
    //         ->groupBy('user_id','question_id');
        
    //     $records = Record::where('user_id', $user->id);

    //     //最新年度の大問
    //     $q_latest = Question::where('year', Question::max('year'));

    //     //大問にログインユーザの記録を紐づけ
    //     $questions = Question::leftjoinSub($records, 'records', function($join) {
    //             $join->on('questions.id', '=', 'records.question_id');
    //         })
    //         //ログインユーザの目標点を紐づけ
    //         ->leftjoinSub($targets, 'targets', function($join) {
    //             $join->on('questions.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
    //         })
    //         ->leftjoinSub($q_latest, 'q_latest', function($join) {
    //             $join->on('questions.subject', '=', 'q_latest.subject')->on('questions.no', '=', 'q_latest.no');
    //         })
    //         ->selectRaw('
    //             questions.subject,
    //             questions.no,
    //             q_latest.content,
    //             count(records.score) as count,
    //             round(avg(questions.point)) as avg_point,
    //             max(records.score) as max_score,
    //             round(avg(records.score)) as avg_score,
    //             round(avg(records.minute)) as avg_minute,
    //             round(avg(targets.target_score)) as target_score,
    //             round(avg(targets.target_minute)) as target_minute,
    //             if(max(records.score)>avg(targets.target_score), "(^^)/◎", "") as max_mark,
    //             if(avg(records.score)>avg(targets.target_score), "(^^)/◎", "") as avg_mark
    //         ')
    //         ->groupBy('questions.subject', 'questions.no', 'q_latest.content')
    //         //並び替え
    //         ->orderBy('questions.subject','asc')
    //         ->orderBy('questions.no','asc')
    //         ->get();

    //         return $questions;
    // }


    public function getSpreadsheet3Data(User $user) {
        //目標点数
        $targets = Target::where('user_id', $user->id);

        //大問に、このユーザの目標点数を結合(※１)
        $questionsWithTargets = Question::where('year', '!=', '2019')
            ->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions.subject', '=', 'targets.subject')
                    ->on('questions.no', '=', 'targets.no');
        })
        ->selectRaw('
            questions.id,
            questions.subject,
            questions.year,
            questions.no,
            targets.target_score,
            targets.target_minute
        ');

        //このユーザの記録を大問ごとに集計(※２)
        $recordsTotal = Record::where('user_id', $user->id)
            ->selectRaw('
                question_id,
                COUNT(score) as count,
                ROUND(AVG(score)) as avg_score
            ')
            ->groupBy('question_id');

        //(※１)に(※２)を結合
        $questionsSet = $questionsWithTargets
            ->leftjoinSub($recordsTotal, 'recordsTotal', function($join) {
                $join->on('questions.id', '=', 'recordsTotal.question_id');
            })
            ->selectRaw('
                questions.*,
                targets.*,
                count,
                avg_score
            ')
            ->orderBy('questions.subject')
            ->orderBy('questions.year','desc')
            ->orderBy('questions.no','asc')
            ->get();

        return $questionsSet;
    }
}

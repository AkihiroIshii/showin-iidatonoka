<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;
use App\Models\Question;
use App\Models\Target;

class AdminController extends Controller
{
    public function show (User $user) {
        //問題
        $questions_sub = Question::where('id', '>', -1);
        // $questions_sub = Question::all();

        //目標点数
        $targets = Target::where('user_id', $user->id);
        // dd($user);

        //演習記録
        $records = Record::leftjoinSub($questions_sub, 'questions_sub', function($join) {
                $join->on('records.question_id', '=', 'questions_sub.id');
            })->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions_sub.subject', '=', 'targets.subject')->on('questions_sub.no', '=', 'targets.no');
            })->where('records.user_id', $user->id)
            // ->selectRaw('
            //     *,
            //     ROUND(100*score/target_score) as score_per_target,
            //     IF(ROUND(100*score/target_score) >= 100, " (^^)/◎", "") as target_mark
            //     ')
            // ->selectRaw('
            //     records.*,
            //     questions_sub.*,
            //     targets.target_score, targets.target_minute,
            //     IF((target_score IS NOT NULL) AND (ROUND(100*score/target_score) >= 100), " (^^)/◎", "") as target_mark
            //     ')
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
            // dd($records);

            // $records = Record::where('user_id', auth()->id())
            // ->orderBy('date','desc')
            // ->leftjoinSub($questions_sub, 'questions_sub', function($join) {
            //     $join->on('records.question_id', '=', 'questions_sub.id');
            // })->joinSub($targets, 'targets', function($join) {
            //     $join->on('questions_sub.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
            // })->get();

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
        $questions = Question::leftjoinSub($records_sub, 'records_sub', function($join) {
                $join->on('questions.id', '=', 'records_sub.question_id');
            })
            //ログインユーザの目標点を紐づけ
            ->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
            })
            ->selectRaw('
                *,
                ROUND(100*max_score/point) as score_rate,
                IF(ROUND(100*max_score/point) >= 80, " (^^)/◎", "") as max_mark,
                IF(max_score >= target_score, " (^^)/◎", "") as target_mark
                ')
            //並び替え
            ->orderBy('type','desc')
            ->orderBy('year','desc')
            ->orderBy('questions.subject','asc')
            ->orderBy('questions.no','asc')
            ->get();
        // return view('record.index', compact('user','records','questions'));

        return view('admin.show', compact('user','records','questions'));
    }

    public function index() {
        // //ログインユーザ
        // $user = User::where('id', auth()->id())->get();

        //生徒
        $users = User::all();
        // dd($users);

        // //問題
        // $questions_sub = Question::where('id', '>', -1);
        // // $questions_sub = Question::all();

        // //目標点数
        // $targets = Target::where('id', '>', -1);

        // //演習記録
        // $records = Record::leftjoinSub($questions_sub, 'questions_sub', function($join) {
        //         $join->on('records.question_id', '=', 'questions_sub.id');
        //     })->joinSub($targets, 'targets', function($join) {
        //         $join->on('questions_sub.subject', '=', 'targets.subject')
        //             ->on('questions_sub.no', '=', 'targets.no')
        //             ->on('records.user_id', '=', 'targets.user_id');
        //     })
        //     ->selectRaw('
        //         *,
        //         ROUND(100*score/target_score) as score_per_target,
        //         IF(ROUND(100*score/target_score) >= 100, " (^^)/◎", "") as target_mark
        //         ')
        //     //並び替え
        //     ->orderBy('date','desc')
        //     ->orderBy('records.id','desc')
        //     ->get();

        //     // $records = Record::where('user_id', auth()->id())
        //     // ->orderBy('date','desc')
        //     // ->leftjoinSub($questions_sub, 'questions_sub', function($join) {
        //     //     $join->on('records.question_id', '=', 'questions_sub.id');
        //     // })->joinSub($targets, 'targets', function($join) {
        //     //     $join->on('questions_sub.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
        //     // })->get();

        // //演習記録（ユーザごと、大問ごとの集計値）
        // $records_sub = Record::where('user_id', auth()->id())
        //     ->select('user_id', 'question_id')
        //     ->selectRaw('
        //         COUNT(score) as count,
        //         MAX(score) as max_score,
        //         ROUND(AVG(score),0) as avg_score,
        //         MAX(date) as latest_date,
        //         ROUND(AVG(minute),0) as avg_minute
        //         ')
        //     ->groupBy('user_id','question_id');

        // //大問にログインユーザの記録を紐づけ
        // $questions = Question::leftjoinSub($records_sub, 'records_sub', function($join) {
        //         $join->on('questions.id', '=', 'records_sub.question_id');
        //     })
        //     //ログインユーザの目標点を紐づけ
        //     ->leftjoinSub($targets, 'targets', function($join) {
        //         $join->on('questions.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
        //     })
        //     ->selectRaw('
        //         *,
        //         ROUND(100*max_score/point) as score_rate,
        //         IF(ROUND(100*max_score/point) >= 80, " (^^)/◎", "") as max_mark,
        //         IF(max_score >= target_score, " (^^)/◎", "") as target_mark
        //         ')
        //     //並び替え
        //     ->orderBy('type','desc')
        //     ->orderBy('year','desc')
        //     ->orderBy('questions.subject','asc')
        //     ->orderBy('questions.no','asc')
        //     ->get();
        // return view('record.index', compact('user','records','questions'));

        // return view('admin.dashboard', compact('users','records','questions')); //管理者専用ページのビュー
        return view('admin.dashboard', compact('users')); //管理者専用ページのビュー
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;
use App\Models\Question;
use App\Models\Target;

class TargetController extends Controller
{
    public function index() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->first();

        //目標テーブルに、記録の平均点と最高点を結合する
        $targets = Target::where('targets.user_id', auth()->id())
            ->leftJoin('questions', function($join) {
                $join->on('targets.subject', '=', 'questions.subject')->on('targets.no', '=', 'questions.no');
            })
            ->leftjoin('records', function($join) {
                $join->on('targets.user_id', '=', 'records.user_id')
                    ->on('questions.id', '=', 'records.question_id');
            })
            ->select('targets.user_id', 'targets.subject', 'targets.no', 'targets.target_score', 'targets.target_minute')
            ->selectRaw('    
                COUNT(records.score) as count,
                MAX(records.score) as max_score,
                ROUND(AVG(records.score)) as avg_score,
                IF(MAX(records.score) > targets.target_score, "(^^)/◎", "") as max_mark,
                IF(AVG(records.score) > targets.target_score, "(^^)/◎", "") as avg_mark,
                ROUND(AVG(questions.point)) as avg_point
            ')
            ->groupBy('targets.user_id', 'targets.subject', 'targets.no', 'targets.target_score', 'targets.target_minute')
            ->get();
        return view('target.index', compact('user','targets'));
    }

    public function show (Target $target) {
        return view('target.show', compact('target'));
    }

    public function edit(Target $target) {
        return view('target.edit', compact('target'));
    }

}

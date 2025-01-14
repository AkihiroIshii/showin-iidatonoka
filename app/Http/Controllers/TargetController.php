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

        //科目ごと大問ごとに、記録の平均点と最高点を集計
        $record_set = Record::where('records.user_id', auth()->id())
            ->leftJoin('questions', function($join) {
                $join->on('records.question_id', '=', 'questions.id');
            })
            ->selectRaw('
                records.user_id,
                questions.subject,
                questions.no,
                count(*) as count,
                max(records.score) as max_score,
                round(avg(records.score)) as avg_score,
                round(avg(questions.point)) as avg_point
            ')
            ->groupBy('records.user_id', 'questions.subject', 'questions.no');

        //目標設定にrecord_setを結合
        $targets = Target::where('targets.user_id', auth()->id())
            ->leftjoinSub($record_set, 'record_set', function($join) {
                $join->on('targets.subject', '=', 'record_set.subject')->on('targets.no', '=', 'record_set.no');
            })
            ->selectRaw('
                targets.id,
                targets.subject,
                targets.no,
                targets.target_score,
                targets.target_minute,
                record_set.count,
                record_set.max_score,
                record_set.avg_score,
                record_set.avg_point,
                IF(record_set.max_score > targets.target_score, "(^^)/◎", "") as max_mark,
                IF(record_set.avg_score > targets.target_score, "(^^)/◎", "") as avg_mark
            ')
            ->get();
// dd($targets);

            // $targets = Target::where('targets.user_id', auth()->id())
            // ->leftJoin('questions', function($join) {
            //     $join->on('targets.subject', '=', 'questions.subject')->on('targets.no', '=', 'questions.no');
            // })
            // ->leftjoin('records', function($join) {
            //     $join->on('targets.user_id', '=', 'records.user_id')
            //         ->on('questions.id', '=', 'records.question_id');
            // })
            // ->select('targets.user_id', 'targets.subject', 'targets.no', 'targets.target_score', 'targets.target_minute')
            // ->selectRaw('
            //     COUNT(records.score) as count,
            //     MAX(records.score) as max_score,
            //     ROUND(AVG(records.score)) as avg_score,
            //     IF(MAX(records.score) > targets.target_score, "(^^)/◎", "") as max_mark,
            //     IF(AVG(records.score) > targets.target_score, "(^^)/◎", "") as avg_mark,
            //     ROUND(AVG(questions.point)) as avg_point
            // ')
            // ->groupBy('targets.user_id', 'targets.subject', 'targets.no', 'targets.target_score', 'targets.target_minute')
            // ->get();

            // dd($targets);
        return view('target.index', compact('user','targets'));
    }

    public function show (Target $target) {
        return view('target.show', compact('target'));
    }

    public function edit(Target $target) {
        return view('target.edit', compact('target'));
    }

    // public function store(Request $request) {
    //     $validated = $request->validate([
    //         // 'user_id' => 'required',
    //         // 'question_id' => 'required',
    //         'date' => 'required',
    //         'year' => 'required',
    //         'subject' => 'required',
    //         'no' => 'required',
    //         'score' => 'required|integer',
    //         'minute' => 'required|integer',
    //         // 'memo' => 'nullable',
    //     ]);

    //     //問題IDを取得
    //     $question = Question::where('year', '=', $validated['year'])
    //         ->where('subject', '=', $validated['subject'])
    //         ->where('no', '=', $validated['no'])
    //         ->first();

    //     $validated['user_id'] = auth()->id();
    //     // $validated['question_id'] = $request->question_id();
    //     $validated['question_id'] = $question->id;
    //     $record = Record::create($validated);
    //     $request->session()->flash('message', '登録しました');
    //     return back();
    // }

    public function update(Request $request, Target $target) {

        $validated = $request->validate([
            'id' => 'required',
            'subject' => 'required',
            'no' => 'required',
            'target_score' => 'required',
            'target_minute' => 'required',
        ]);

        $target->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();

    }

}

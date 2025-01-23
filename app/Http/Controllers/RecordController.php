<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;
use App\Models\Question;
use App\Models\Target;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    public function index() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->first();

        //問題
        $questions_sub = Question::where('id', '>', -1);
        // $questions_sub = Question::all();

        //目標点数
        $targets = Target::where('user_id', auth()->id());

        //演習記録
        $records = Record::leftjoinSub($questions_sub, 'questions_sub', function($join) {
                $join->on('records.question_id', '=', 'questions_sub.id');
            })->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions_sub.subject', '=', 'targets.subject')->on('questions_sub.no', '=', 'targets.no');
            })->where('records.user_id', auth()->id())
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

        //演習記録（ユーザごと、大問ごとの集計値）
        $records_sub = Record::where('user_id', auth()->id())
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

        //演習記録（該当ユーザの集計値）
        $records_sum_per_user = Record::select('user_id')
            ->selectRaw('
                COUNT(score) as count,
                ROUND(SUM(minute)/60, 1) as sum_hour
            ')
            ->groupBy('user_id')
            ->get();

        //この生徒の集計値
        $records_sum_this_user = $records_sum_per_user->firstWhere('user_id', auth()->id());
        //演習時間トップの生徒の集計値
        $maxMinute = $records_sum_per_user->max('sum_hour');
        $records_sum_top_user = $records_sum_per_user->firstWhere('sum_hour', $maxMinute);
        
        return view('record.index', compact('user','records','questions','records_sum_this_user','records_sum_top_user'));
    }

    public function spreadsheet() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->get();

        //目標点数
        $targets = Target::where('user_id', auth()->id());

        //演習記録（ユーザごと、大問ごとの集計値）
        $records_sub = Record::where('user_id', auth()->id())
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
        return view('record.spreadsheet', compact('user','questions'));
    }

    //レコード集計２（年度も集約）
    public function spreadsheet2() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->get();

        //目標点数
        $targets = Target::where('user_id', auth()->id());

        //演習記録（ユーザごと、大問ごとの集計値）
        $records_sub = Record::where('user_id', auth()->id())
            ->select('user_id', 'question_id')
            ->selectRaw('
                COUNT(score) as count,
                MAX(score) as max_score,
                ROUND(AVG(score),0) as avg_score,
                MAX(date) as latest_date,
                ROUND(AVG(minute),0) as avg_minute
            ')
            ->groupBy('user_id','question_id');
        
        $records = Record::where('user_id', auth()->id());

        //最新年度の大問
        $q_latest = Question::where('year', Question::max('year'));

        //大問にログインユーザの記録を紐づけ
        $questions = Question::leftjoinSub($records, 'records', function($join) {
                $join->on('questions.id', '=', 'records.question_id');
            })
            //ログインユーザの目標点を紐づけ
            ->leftjoinSub($targets, 'targets', function($join) {
                $join->on('questions.subject', '=', 'targets.subject')->on('questions.no', '=', 'targets.no');
            })
            ->leftjoinSub($q_latest, 'q_latest', function($join) {
                $join->on('questions.subject', '=', 'q_latest.subject')->on('questions.no', '=', 'q_latest.no');
            })
            ->selectRaw('
                questions.subject,
                questions.no,
                q_latest.content,
                count(records.score) as count,
                round(avg(questions.point)) as avg_point,
                max(records.score) as max_score,
                round(avg(records.score)) as avg_score,
                round(avg(records.minute)) as avg_minute,
                round(avg(targets.target_score)) as target_score,
                round(avg(targets.target_minute)) as target_minute,
                if(max(records.score)>avg(targets.target_score), "(^^)/◎", "") as max_mark,
                if(avg(records.score)>avg(targets.target_score), "(^^)/◎", "") as avg_mark
            ')
            ->groupBy('questions.subject', 'questions.no', 'q_latest.content')
            //並び替え
            ->orderBy('questions.subject','asc')
            ->orderBy('questions.no','asc')
            ->get();
        return view('record.spreadsheet2', compact('user','questions'));
    }

    public function show (Record $record) {
        // dd($record);
        return view('record.show', compact('record'));
    }

    public function edit(Record $record) {
        // dd($record);
        return view('record.edit', compact('record'));
    }

    public function create() {
        return view('record.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            // 'user_id' => 'required',
            // 'question_id' => 'required',
            'date' => 'required',
            'year' => 'required',
            'subject' => 'required',
            'no' => 'required',
            'score' => 'required|integer',
            'minute' => 'required|integer',
            // 'memo' => 'nullable',
        ]);

        //問題IDを取得
        $question = Question::where('year', '=', $validated['year'])
            ->where('subject', '=', $validated['subject'])
            ->where('no', '=', $validated['no'])
            ->first();

        $validated['user_id'] = auth()->id();
        // $validated['question_id'] = $request->question_id();
        $validated['question_id'] = $question->id;
        $record = Record::create($validated);
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update(Request $request, Record $record) {

        $validated = $request->validate([
            'date' => 'required',
            'year' => 'required',
            'subject' => 'required',
            'no' => 'required',
            'score' => 'required|integer',
            'minute' => 'required|integer',
        ]);

        //問題IDを取得
        $question = Question::where('year', '=', $validated['year'])
            ->where('subject', '=', $validated['subject'])
            ->where('no', '=', $validated['no'])
            ->first();

        $validated['user_id'] = auth()->id();
        $validated['question_id'] = $question->id;
        $record->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();

    }
}

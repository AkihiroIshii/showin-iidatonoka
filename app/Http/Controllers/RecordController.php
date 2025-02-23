<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\UserTrait;
use App\Traits\RecordTrait;
use App\Models\Record;
use App\Models\Question;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RecordRequest;

class RecordController extends Controller
{
    use UserTrait;
    use RecordTrait;

    public function index() {
        //管理者なら対象ユーザを、ほかのユーザなら自分を対象とする。
        $user = $this->targetUser(Auth::user());

        $records = $this->getRecords($user);

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
        
        return view('record.index', compact('user','records','records_sum_this_user','records_sum_top_user'));
    }

    //レコード集計１
    public function spreadsheet(User $user) {
        $questions = $this->getSpreadsheetData($user); //app/Traits/RecordTrait.phpを参照
        return view('record.spreadsheet', compact('user','questions'));
    }

    //レコード集計２（年度も集約）
    public function spreadsheet2(User $user) {
        $questions = $this->getSpreadsheet2Data($user);

        $groupedQuestions = $questions->groupBy('subject')->map(function ($group) {
            return $group->chunk(6);
        });

        return view('record.spreadsheet2', compact('user','groupedQuestions','questions'));
    }

    //レコード集計３（科目ごと）
    public function spreadsheet3(User $user) {
        $questionsSet = $this->getSpreadsheet3Data($user);
        return view('record.spreadsheet3', compact('user','questionsSet'));
    }

    //解答用紙
    public function answersheet(User $user) {
        $questionsSet = $this->getSpreadsheet3Data($user);
        return view('record.answersheet', compact('user'));
    }

    // public function show (Record $record) {
    //     // dd($record);
    //     return view('record.show', compact('record'));
    // }

    public function edit(Record $record) {
        //ログインユーザ
        $user = User::where('id', auth()->id())->get();
        return view('record.edit', compact('record', 'user'));
    }

    public function create() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->get();
        return view('record.create', compact('user'));
    }

    public function store(RecordRequest $request) {
        //問題IDを取得
        $question = Question::where('year', '=', $request['year'])
            ->where('subject', '=', $request['subject'])
            ->where('no', '=', $request['no'])
            ->first();

        $request['user_id'] = auth()->id();
        // $validated['question_id'] = $request->question_id();
        $request['question_id'] = $question->id;
        $record = Record::create($request->all());
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update(RecordRequest $request, Record $record) {
        //問題IDを取得
        $question = Question::where('year', '=', $request['year'])
            ->where('subject', '=', $request['subject'])
            ->where('no', '=', $request['no'])
            ->first();

        $request['user_id'] = auth()->id();
        $request['question_id'] = $question->id;
        $record->update($request->all());

        $request->session()->flash('message', '更新しました');
        return back();

    }
}

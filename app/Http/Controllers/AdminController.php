<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;
use App\Models\Question;
use App\Models\Target;
use App\Models\Event;
use App\Models\Usualtarget;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function show (User $user) {
        //問題
        $questions_sub = Question::where('id', '>', -1);
        // $questions_sub = Question::all();

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

        //演習記録（該当ユーザの集計値）
        $records_sum_per_user = Record::select('user_id')
            ->selectRaw('
                COUNT(score) as count,
                ROUND(SUM(minute)/60, 1) as sum_hour
            ')
            ->groupBy('user_id')
            ->get();

        //この生徒の集計値
        $records_sum_this_user = $records_sum_per_user->firstWhere('user_id', $user->id);

        //演習時間トップの生徒の集計値
        $maxMinute = $records_sum_per_user->max('sum_hour');
        $records_sum_top_user = $records_sum_per_user->firstWhere('sum_hour', $maxMinute);

        return view('admin.show', compact('user','records','questions','records_sum_this_user','records_sum_top_user'));
    }

    public function spreadsheet (User $user) {
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

        return view('admin.spreadsheet', compact('user', 'questions'));
    }

    public function index() {
        //生徒
        $users = User::leftJoin('schools', function($join) {
                $join->on('users.school_id', '=', 'schools.id');
            })
            ->selectRaw('
                users.id,
                users.name as user_name,
                schools.name as school_name,
                users.grade,
                users.plan
            ')
            ->orderBy('users.grade','desc')
            ->orderBy('users.plan','asc')
            ->orderBy('users.id','asc')
            ->orderBy('schools.name','asc')
            ->get();
        return view('admin.dashboard', compact('users')); //管理者専用ページのビュー
    }

    public function link() {
        return view('admin.link');
    }

    public function maintain() {
        return view('admin.maintain');
    }

    public function workbook() {
        return view('admin.workbook');
    }

    public function event() {
        $startDate = Carbon::today()->startOfDay();
        $endDate = Carbon::today()->addMonth(2)->endOfDay();  //２か月後
        
        //イベント（本日から１か月間）
        $events = Event::whereBetween('events.date_from', [$startDate, $endDate])
            ->leftJoin('schools', function ($join) {
                $join->on('events.school_id', '=', 'schools.id');
            })
            ->selectRaw("
                events.*,
                schools.name,
                IF(events.date_from = events.date_to,
                    DATE_FORMAT(events.date_from, '%c/%e'),
                    CONCAT(
                        CONCAT(DATE_FORMAT(events.date_from, '%c/%e'), '～'),
                        DATE_FORMAT(events.date_to, '%c/%e')
                    )
                ) as formatted_date
            ")
            ->orderBy('events.date_from', 'asc')
            ->get();
            
        return view('event.index', compact('events'));
    }

    public function usualtarget(User $user) {
        $today = Carbon::today();
        $usualtargets = Usualtarget::where('user_id', $user->id)
            ->selectRaw("
                id,
                user_id,
                DATE_FORMAT(set_date, '%c/%e') as formatted_set_date,
                DATE_FORMAT(due_date, '%c/%e') as formatted_due_date,
                content,
                achieve_flg,
                IF(
                    achieve_flg = 1,
                    '目標達成！(^^)/◎',
                    IF(
                        due_date < ?,
                        '期限切れ(´・ω・｀)',
                        '挑戦中'
                    )
                ) as achieve_mark,
                comment,
                coin
            ", [$today])
            ->get();

        return view('admin.usualtarget.index', compact('user','usualtargets'));
    }

    public function edit_usualtarget(Usualtarget $usualtarget) {
        $user = User::where('id', $usualtarget->user_id)->first();
        return view('admin.usualtarget.edit', compact('usualtarget','user'));
    }

    public function create_usualtarget(User $user) {
        return view('admin.usualtarget.create', compact('user'));
    }

    public function store_usualtarget(Request $request, User $user) {

        $validated = $request->validate([
            'content' => 'required',
            'due_date' => 'required'
        ]);

        $today = Carbon::today();

        $validated['user_id'] = $user->id;
        $validated['set_date'] = $today;

        $usualtarget = Usualtarget::create($validated);

        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_usualtarget(Request $request, Usualtarget $usualtarget) {

        $validated = $request->validate([
            'content' => 'required',
            'achieve_flg' => 'boolean',
            'coin' => 'required|integer',
            'comment' => 'required'
        ]);

        $usualtarget->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\UserTrait;
use App\Models\Record;
use App\Traits\RecordTrait;
use App\Models\Question;
use App\Models\Target;
use App\Models\Event;
use App\Models\Usualtarget;
use App\Models\Workbook;
use Carbon\Carbon;

class AdminController extends Controller
{
    use UserTrait;
    use RecordTrait;

    public function show (User $user) {
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
        $records_sum_this_user = $records_sum_per_user->firstWhere('user_id', $user->id);

        //演習時間トップの生徒の集計値
        $maxMinute = $records_sum_per_user->max('sum_hour');
        $records_sum_top_user = $records_sum_per_user->firstWhere('sum_hour', $maxMinute);

        return view('admin.show', compact('user','records','records_sum_this_user','records_sum_top_user'));
    }

    public function spreadsheet (User $user) {
        $questions = $this->getSpreadsheetData($user);

        return view('admin.spreadsheet', compact('user', 'questions'));
    }

    public function spreadsheet3 (User $user) {
        $questionsSet = $this->getSpreadsheet3Data($user);

        return view('admin.spreadsheet3', compact('user','questionsSet'));
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

    /** 日々の目標 */
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

    /** 問題集 */
    public function workbook() {
        $workbooks = Workbook::query()
            ->orderBy('subject','asc')
            ->orderBy('grade','desc')
            ->get();

        return view('admin.workbook.index', compact('workbooks'));
    }

    public function edit_workbook(Workbook $workbook) {
        return view('admin.workbook.edit', compact('workbook'));
    }

    public function create_workbook() {
        return view('admin.workbook.create');
    }

    public function store_workbook(Request $request) {

        $validated = $request->validate([
            'subject' => 'required',
            'field' => 'required',
            'grade' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'reference' => 'nullable'
        ]);

        $workbook = Workbook::create($validated);

        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_workbook(Request $request, Workbook $workbook) {

        $validated = $request->validate([
            'subject' => 'required',
            'field' => 'required',
            'grade' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'reference' => 'nullable'
        ]);

        $workbook->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }

}

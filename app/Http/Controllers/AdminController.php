<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Traits\UserTrait;
use App\Models\School;
use App\Models\Record;
use App\Traits\RecordTrait;
use App\Models\Question;
use App\Models\Target;
use App\Models\Event;
use App\Models\Usualtarget;
use App\Traits\UsualtargetTrait;
use App\Models\Workbook;
use App\Models\Exam;
use App\Traits\ExamTrait;
use App\Models\ExamResult;
use App\Models\Workrecord;
use Carbon\Carbon;

class AdminController extends Controller
{
    use UserTrait;
    use RecordTrait;
    use ExamTrait;
    use UsualtargetTrait;

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

    /** 過去問目標点数 */
    public function target(User $user) {
        
        //科目ごと大問ごとに、記録の平均点と最高点を集計
        $record_set = Record::where('records.user_id', $user->id)
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
        $targets = Target::where('targets.user_id', $user->id)
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

        return view('admin.target.index', compact('user','targets'));
    }    

    /** 日々の目標 */
    public function usualtarget(User $user) {
            $usualtargets = $this->getUsualtargets($user);
            $lastMonthCoinSum = $this->getLastMonthCoinSum($user);
            $thisMonthCoinSum = $this->getThisMonthCoinSum($user);

        return view('admin.usualtarget.index', compact('user','usualtargets','lastMonthCoinSum','thisMonthCoinSum'));
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

    /** テスト結果 */
    public function exam(User $user) {
        $examresults = $this->getExamResults($user);
        return view('admin.exam.index', compact('user','examresults'));
    }

    // public function edit_usualtarget(Usualtarget $usualtarget) {
    //     $user = User::where('id', $usualtarget->user_id)->first();
    //     return view('admin.usualtarget.edit', compact('usualtarget','user'));
    // }

    // public function create_usualtarget(User $user) {
    //     return view('admin.usualtarget.create', compact('user'));
    // }

    // public function store_usualtarget(Request $request, User $user) {

    //     $validated = $request->validate([
    //         'content' => 'required',
    //         'due_date' => 'required'
    //     ]);

    //     $today = Carbon::today();

    //     $validated['user_id'] = $user->id;
    //     $validated['set_date'] = $today;

    //     $usualtarget = Usualtarget::create($validated);

    //     $request->session()->flash('message', '登録しました');
    //     return back();
    // }

    // public function update_usualtarget(Request $request, Usualtarget $usualtarget) {

    //     $validated = $request->validate([
    //         'content' => 'required',
    //         'achieve_flg' => 'boolean',
    //         'coin' => 'required|integer',
    //         'comment' => 'required'
    //     ]);

    //     $usualtarget->update($validated);

    //     $request->session()->flash('message', '更新しました');
    //     return back();

    // }

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

    /** ユーザ */
    public function create_user() {
        $schools = School::all();

        return view('admin.user.create', compact('schools'));
    }

    public function edit_user(User $user) {
        return view('admin.user.edit', compact('user'));
    }

    public function store_user(Request $request) {

        $validated = $request->validate([
            'user_id' => 'required',
            'password' => 'required',
            'name' => 'required',
            'school_id' => 'required',
            'grade' => 'required',
            'plan' => 'required'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_user(Request $request, User $user) {

        $validated = $request->validate([
            'user_id' => 'required',
            'password' => 'required',
            'name' => 'required',
            'school_id' => 'required',
            'grade' => 'required',
            'plan' => 'required'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }

    /** ワーク演習結果 */
    public function workrecord(User $user) {
        $workrecords = Workrecord::where('user_id', $user->id)
            ->leftJoin('exams', function($join){
                $join->on('workrecords.exam_id', '=', 'exams.id');
            })
            ->selectRaw('
                workrecords.*,
                exams.exam_date,
                exams.exam_name
            ')
            ->orderBy('exams.exam_date','asc')
            ->orderBy('subject','asc')
            ->get();

        return view('admin.workrecord.index', compact('user', 'workrecords'));
    }

    public function create_workrecord(User $user) {
        $exams = Exam::where('school_id', $user->school_id)
            ->where('grade', $user->grade)
            ->get();

        return view('admin.workrecord.create', compact('user', 'exams'));
    }

    public function edit_workrecord(Workrecord $workrecord) {
        $user = User::where('id', $workrecord->user_id)->first();
        $exams = Exam::where('school_id', $user->school_id)
            ->where('grade', $user->grade)
            ->get();
        return view('admin.workrecord.edit', compact('user', 'exams', 'workrecord'));
    }

    public function store_workrecord(Request $request) {

        $validated = $request->validate([
            'user_id' => 'required',
            'exam_id' => 'required',
            'subject' => 'required',
            'work_name' => 'nullable',
            'work_range' => 'nullable',
            'memo' => 'nullable',
            'date_1st' => 'nullable',
            'date_2nd' => 'nullable',
            'date_3rd' => 'nullable',
        ]);

        Workrecord::create($validated);

        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_workrecord(Request $request, Workrecord $workrecord) {

        $validated = $request->validate([
            'user_id' => 'required',
            'exam_id' => 'required',
            'subject' => 'required',
            'work_name' => 'nullable',
            'work_range' => 'nullable',
            'memo' => 'nullable',
            'date_1st' => 'nullable',
            'date_2nd' => 'nullable',
            'date_3rd' => 'nullable',
        ]);

        $workrecord->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }
}

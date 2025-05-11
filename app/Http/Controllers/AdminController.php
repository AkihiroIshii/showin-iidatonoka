<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Traits\UserTrait;
use App\Models\School;
use App\Models\Record;
use App\Traits\RecordTrait;
use App\Models\Question;
use App\Models\Target;
use App\Models\Usualtarget;
use App\Models\Transfer;
use App\Traits\UsualtargetTrait;
use App\Models\Workbook;
use App\Models\Exam;
use App\Traits\ExamTrait;
use App\Models\ExamResult;
use App\Models\Information;
use App\Models\Workrecord;
use Carbon\Carbon;
use App\Http\Requests\WorkrecordRequest;
use App\Http\Requests\WorkbookRequest;
use App\Http\Requests\UserRequest;

class AdminController extends Controller
{
    use UserTrait;
    use RecordTrait;
    use ExamTrait;
    use UsualtargetTrait;

    public function setStudent (User $user) {
        //閲覧対象とする生徒IDをセッションに記録
        Session::put('target_students', $user->id);

        return redirect()->route('record');
    }

    // adminのdashboard
    public function index() {
        //生徒
        $users = $this->getUsers();

        $informations = Information::query()
            ->orderBy('updated_at','desc')
            ->get();

        $usualtargets = $this->getTargetsByToday();

        $transfers = Transfer::from('transfers as t')
            ->where('t.status', '申請中')
            ->LeftJoin('users', 'users.id', '=', 't.user_id')
            ->selectRaw('
                t.*,
                ROUND(
                    (TIME_TO_SEC(COALESCE(t.time_to_absence_1, 0)) - TIME_TO_SEC(COALESCE(t.time_from_absence_1, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_absence_2, 0)) - TIME_TO_SEC(COALESCE(t.time_from_absence_2, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_absence_3, 0)) - TIME_TO_SEC(COALESCE(t.time_from_absence_3, 0))) / 60
                , 0) as sum_t_abs,
                ROUND(
                    (TIME_TO_SEC(COALESCE(t.time_to_alternative_1, 0)) - TIME_TO_SEC(COALESCE(t.time_from_alternative_1, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_alternative_2, 0)) - TIME_TO_SEC(COALESCE(t.time_from_alternative_2, 0))) / 60
                    + (TIME_TO_SEC(COALESCE(t.time_to_alternative_3, 0)) - TIME_TO_SEC(COALESCE(t.time_from_alternative_3, 0))) / 60
                , 0) as sum_t_alt,
                users.name as user_name
            ')
            ->orderBy('t.alternative_day_1','asc')
            ->orderBy('t.user_id','asc')
            ->get();
        return view('admin.dashboard', compact('users','informations','usualtargets','transfers')); //管理者専用ページのビュー
    }

    public function students() {
        //生徒
        $users = $this->getUsers();

        $usualtargets = $this->getTargetsByToday();

        return view('admin.students', compact('users','usualtargets')); //管理者専用ページのビュー
    }

    public function maintain() {
        return view('admin.maintain');
    }

    // /** 試験一覧 */
    // public function examList() {
    //     $examresults = $this->getExamResults($user);
    //     return view('admin.exam.index', compact('user','examresults'));
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

    public function store_workbook(WorkbookRequest $request) {
        $workbook = Workbook::create($request->all());
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_workbook(WorkbookRequest $request, Workbook $workbook) {
        $workbook->update($request->all());
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

    public function store_user(UserRequest $request) {
        $request['password'] = Hash::make($request['password']);        
        User::create($request->all());
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_user(UserRequest $request, User $user) {
        $request['password'] = Hash::make($request['password']);
        $user->update($request->all());
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

    public function store_workrecord(WorkrecordRequest $request) {
        Workrecord::create($request->all());
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update_workrecord(WorkrecordRequest $request, Workrecord $workrecord) {
        $workrecord->update($request->all());
        $request->session()->flash('message', '更新しました');
        return back();
    }
}

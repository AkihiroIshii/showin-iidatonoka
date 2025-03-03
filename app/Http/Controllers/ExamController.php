<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Traits\ExamTrait;
use App\Models\User;
use App\Models\School;
use App\Models\Exam;

class ExamController extends Controller
{
    use ExamTrait;
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function index() {
        $user = User::where('id', $this->user->id)->first();
        $examresults = $this->getExamResults($user);
        return view('exam.index', compact('user','examresults'));
    }

    /* 管理者用 */
    public function getAllExams() {
        $exams = Exam::leftJoin('schools', function($join){
            $join->on('exams.school_id', '=', 'schools.id');
        })
        ->selectRaw('
            exams.*,
            schools.name as schoolName
        ')
        ->orderBy('exams.exam_date','desc')
        ->orderBy('exams.grade','desc')
        ->get();
        return view('exam.list', compact('exams'));
    }

    public function create() {
        //ログインユーザ
        $schools = School::where('name', 'LIKE', '%中%')
            ->orWhere('name', 'LIKE', '%高%')
            ->get();
        return view('exam.create', compact('schools'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'school_id' => 'required',
            'year' => 'required',
            'grade' => 'required', 
            'no' => 'required', 
            'exam_date' => 'required',
            'exam_name' => 'required',
            'avg_japanese' => 'nullable',
            'avg_society' => 'nullable',
            'avg_math' => 'nullable', 
            'avg_science' => 'nullable',
            'avg_english' => 'nullable',
        ]);
        $exam = Exam::create($validated);
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Exam $exam) {
        //ログインユーザ
        // $user = User::where('id', $this->user->id)->first();
        $schools = School::where('name', 'LIKE', '%中%')
            ->orWhere('name', 'LIKE', '%高%')
            ->get();
        return view('exam.edit', compact('exam','schools'));
    }

    public function update(Request $request, Exam $exam) {

        try {
            $validated = $request->validate([
                'school_id' => 'required',
                'year' => 'required',
                'grade' => 'required', 
                'no' => 'required', 
                'exam_date' => 'required',
                'exam_name' => 'required',
                'avg_japanese' => 'nullable',
                'avg_society' => 'nullable',
                'avg_math' => 'nullable', 
                'avg_science' => 'nullable',
                'avg_english' => 'nullable',
            ]);
        
            // バリデーション成功時にここに到達する
            // dd($validated);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // バリデーションエラーの内容を確認
            dd($e->errors());
        }
        
        $exam->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();

    }
    
}

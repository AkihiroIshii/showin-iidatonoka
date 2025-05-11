<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
// use App\Traits\ExamTrait;
use App\Models\User;
use App\Models\School;
use App\Models\Exam;
use App\Models\Examresult;
use App\Traits\ExamresultTrait;

class ExamresultController extends Controller
{
    use ExamresultTrait;
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
        $this->school = School::where('id', $this->user->school_id)->first();
    }
    
    public function index() {
        $user = $this->user;
        $examresults = $this->getExamresultsWithAverage();
        // dd($examresults);
        return view('examresult.index', compact('user','examresults'));
    }

    // public function show(int $exam_id) {
    //     Session::put('exam_id', $exam_id);
    //     return redirect(route('exam.show'));
    // }

    public function create() {
        $exams = Exam::where('school_id', $this->school->id)
        ->orWhere('school_id', 902) //外部（なが模試）
        ->orderBy('grade', 'desc')
        ->orderBy('exam_date', 'desc')
            ->get();
        $user = $this->user;
        return view('examresult.create', compact('exams', 'user'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'exam_id' => 'required',
            'score_japanese' => 'nullable',
            'score_society' => 'nullable',
            'score_math' => 'nullable',
            'score_science' => 'nullable',
            'score_english' => 'nullable',
        ]);
        $validated['user_id'] = $this->user->id;
        $examresult = Examresult::create($validated);
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Examresult $examresult) {
        $exams = Exam::where('school_id', $this->school->id)
            ->orWhere('school_id', 902) //外部（なが模試）
            ->orderBy('grade', 'desc')
            ->orderBy('exam_date', 'desc')
            ->get();
        $user = $this->user;
        return view('examresult.edit', compact('examresult','exams','user'));
    }

    public function update(Request $request, Examresult $examresult) {

        try {
            $validated = $request->validate([
                'exam_id' => 'required',
                'score_japanese' => 'nullable',
                'score_society' => 'nullable',
                'score_math' => 'nullable',
                'score_science' => 'nullable',
                'score_english' => 'nullable',
            ]);
            $validated['user_id'] = $this->user->id;
        
            // バリデーション成功時にここに到達する
            // dd($validated);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // バリデーションエラーの内容を確認
            dd($e->errors());
        }
        
        $examresult->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();

    }

}

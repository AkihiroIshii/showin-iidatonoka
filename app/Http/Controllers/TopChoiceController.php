<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TopChoice;
use App\Models\User;
use App\Traits\TopChoiceTrait;

class TopChoiceController extends Controller
{
    use TopChoiceTrait;
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function index() {
        $user = $this->user;
        $top_choices = $this->get_top_choices();
        $grouped_top_choices = $top_choices->groupBy('name');
        return view('top_choice.index',compact('user','grouped_top_choices'));
    }

    public function create() {
        $user = $this->user;
        return view('top_choice.create',compact('user'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'school_name' => 'required',
            'department' => 'required',
            'desired_ranking' => 'nullable',
            'selection_method' => 'nullable',
            'exam_date' => 'nullable',
            'subjects' => 'nullable',
            'mock_date' => 'nullable',
            'mock_name' => 'nullable',
            'mock_judge' => 'nullable',
            'memo' => 'nullable',
            'num_capacity' => 'nullable',
        ]);
        $validated['student_id'] = $this->user->id;
        $top_choice = TopChoice::create($validated);
        $request->session()->flash('message', '登録しました');
        if(Auth::user()->role == "admin") {
            return back();
        } else {
            return redirect(route('dashboard'));
        }
    }

    public function edit(TopChoice $top_choice) {
        $user = $this->user;
        return view('top_choice.edit', compact('top_choice','user'));
    }

    public function update(Request $request, TopChoice $top_choice) {
        try {
            $validated = $request->validate([
                'school_name' => 'required',
                'department' => 'required',
                'desired_ranking' => 'nullable',
                'selection_method' => 'nullable',
                'exam_date' => 'nullable',
                'subjects' => 'nullable',
                'mock_date' => 'nullable',
                'mock_name' => 'nullable',
                'mock_judge' => 'nullable',
                'memo' => 'nullable',
                'num_capacity' => 'nullable',
            ]);
            $validated['student_id'] = $this->user->id;
        
            // バリデーション成功時にここに到達する
            // dd($validated);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // バリデーションエラーの内容を確認
            dd($e->errors());
        }
        
        $top_choice->update($validated);

        $request->session()->flash('message', '更新しました');
        if(Auth::user()->role == "admin") {
            return back();
        } else {
            return redirect(route('dashboard'));
        }
    }
}

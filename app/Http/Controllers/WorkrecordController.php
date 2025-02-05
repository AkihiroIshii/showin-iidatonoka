<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workrecord;
use App\Models\User;
use App\Models\Exam;

class WorkrecordController extends Controller
{
    /** ワーク演習結果 */
    public function index() {
        $user = User::where('id', auth()->id())->first();
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

        return view('workrecord.index', compact('user', 'workrecords'));
    }

    public function create() {
        $user = User::where('id', auth()->id())->first();
        $exams = Exam::where('school_id', $user->school_id)
            ->where('grade', $user->grade)
            ->get();

        return view('workrecord.create', compact('user', 'exams'));
    }

    public function edit(Workrecord $workrecord) {
        $user = User::where('id', $workrecord->user_id)->first();
        $exams = Exam::where('school_id', $user->school_id)
            ->where('grade', $user->grade)
            ->get();
        return view('workrecord.edit', compact('user', 'exams', 'workrecord'));
    }

    public function store(Request $request) {

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

    public function update(Request $request, Workrecord $workrecord) {

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

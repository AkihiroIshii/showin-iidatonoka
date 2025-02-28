<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\WorkrecordRequest;
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

    public function store(WorkrecordRequest $request) {
        Storage::disk('local')->putFile('files', $request->file('file'));
        return back();
        Workrecord::create($request);
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function update(WorkrecordRequest $request, Workrecord $workrecord) {
        $workrecord->update($request->all());
        $request->session()->flash('message', '更新しました');
        return back();
    }
}

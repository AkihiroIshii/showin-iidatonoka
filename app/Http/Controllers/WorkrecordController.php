<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workrecord;
use App\Models\User;

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
}

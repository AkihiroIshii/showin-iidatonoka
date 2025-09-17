<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use App\Models\Aishowin;
use App\Models\Mojizou;
use App\Models\Kawaijukuone;
use App\Models\CompletedUnit;
use App\Models\User;

class CompletedUnitController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
        $this->user_ids = Arr::wrap(Session::get('target_students'));
        $this->user_grades = User::whereIn('id', $this->user_ids)->pluck('grade');
    }

    public function index()
    {
        $user = $this->user;

        // AI-Showin
        // $grouped_completed_unit_aishowins = Aishowin::whereIn('aishowins.grade', $this->user_grades)
        //     ->leftJoin('completed_units', function($join){
        //         $join->on('completed_units.unit_id_aishowin', '=', 'aishowins.id')
        //             ->where('completed_units.teaching_material', 'AI-Showin')
        //             ->whereIn('completed_units.user_id', $this->user_ids);
        //     })
        //     ->leftJoin('users', 'completed_units.user_id', '=', 'users.id')
        //     ->selectRaw('
        //         completed_units.*,
        //         aishowins.grade,
        //         aishowins.unit,
        //         aishowins.num_level,
        //         aishowins.explanation,
        //         IF(users.name = '', 
        //     ')
        //     ->orderBy('completed_units.completed_date', 'desc')
        //     ->get()
        //     ->groupBy('name');

        $grouped_completed_unit_aishowins = CompletedUnit::whereIn('completed_units.user_id', $this->user_ids)
            ->where('completed_units.teaching_material', 'AI-Showin')
            ->leftJoin('aishowins', 'completed_units.unit_id_aishowin', '=', 'aishowins.id')
            ->leftJoin('users', 'completed_units.user_id', '=', 'users.id')
            ->selectRaw('
                completed_units.*,
                aishowins.grade,
                aishowins.unit,
                aishowins.num_level,
                aishowins.explanation,
                users.name
            ')
            ->orderBy('completed_units.completed_date', 'desc')
            ->orderBy('completed_units.target_date', 'desc')
            ->get()
            ->groupBy('name');
        $latest_date_updated_aishowins = $grouped_completed_unit_aishowins->flatten()->whereNotNull('updated_at')->max('updated_at');;

        // moji蔵
        $grouped_completed_unit_mojizous = CompletedUnit::whereIn('completed_units.user_id', $this->user_ids)
            ->where('teaching_material', 'moji蔵')
            ->leftJoin('mojizous', 'completed_units.unit_id_mojizou', '=', 'mojizous.id')
            ->leftJoin('users', 'completed_units.user_id', '=', 'users.id')
            ->selectRaw('
                completed_units.*,
                mojizous.grade,
                mojizous.category,
                mojizous.topic,
                mojizous.num_question,
                users.name
            ')
            ->orderBy('completed_units.completed_date', 'desc')
            ->orderBy('completed_units.target_date', 'desc')
            ->get()
            ->groupBy('name');
        $latest_date_updated_mojizous = $grouped_completed_unit_mojizous->flatten()->whereNotNull('updated_at')->max('updated_at');;

        // 河合塾One
        $grouped_completed_unit_kawaijukuones = CompletedUnit::whereIn('completed_units.user_id', $this->user_ids)
            ->where('teaching_material', '河合塾One')
            ->leftJoin('kawaijukuones', 'completed_units.unit_id_kawaijukuone', '=', 'kawaijukuones.id')
            ->leftJoin('users', 'completed_units.user_id', '=', 'users.id')
            ->selectRaw('
                completed_units.*,
                kawaijukuones.subject_1,
                kawaijukuones.subject_2,
                kawaijukuones.section,
                kawaijukuones.num_topic,
                users.name
            ')
            ->orderBy('completed_units.completed_date', 'desc')
            ->orderBy('completed_units.target_date', 'desc')
            ->get()
            ->groupBy('name');
        $latest_date_updated_kawaijukuones = $grouped_completed_unit_kawaijukuones->flatten()->whereNotNull('updated_at')->max('updated_at');

        return view('completedunit.index', compact(
            'grouped_completed_unit_aishowins', 'grouped_completed_unit_mojizous','grouped_completed_unit_kawaijukuones',
            'latest_date_updated_aishowins', 'latest_date_updated_mojizous', 'latest_date_updated_kawaijukuones',
            'user'));
    }

    public function create() {
        $user = $this->user;
        $aishowins = Aishowin::all();
        $mojizous = Mojizou::all();
        $kawaijukuones = Kawaijukuone::all();
        return view('completedunit.create', compact('user','aishowins','mojizous','kawaijukuones'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'teaching_material' => 'required',
            'unit_id_aishowin' => 'nullable',
            'num_loop' => 'nullable', 
            'unit_id_mojizou' => 'nullable',
            'unit_id_kawaijukuone' => 'nullable',
            'target_date' => 'nullable', 
            'completed_date' => 'nullable', 
            'memo' => 'nullable'
        ]);

        $user_id = Session::get('target_students');
        $validated['user_id'] = $user_id;

        $completedunit = CompletedUnit::create($validated);

        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(CompletedUnit $completedunit) {
        $user = $this->user;
        $aishowins = Aishowin::all();
        $mojizous = Mojizou::all();
        $kawaijukuones = Kawaijukuone::all();
        return view('completedunit.edit', compact('completedunit','user','aishowins','mojizous','kawaijukuones'));
    }

    public function update(Request $request, CompletedUnit $completedunit) {
        $validated = $request->validate([
            'teaching_material' => 'required',
            'unit_id_aishowin' => 'nullable',
            'num_loop' => 'nullable', 
            'unit_id_mojizou' => 'nullable',
            'unit_id_kawaijukuone' => 'nullable',
            'target_date' => 'nullable', 
            'completed_date' => 'nullable', 
            'memo' => 'nullable'
        ]);

        $user_id = Session::get('target_students');
        $validated['user_id'] = $user_id;

        $completedunit->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();

    }
}

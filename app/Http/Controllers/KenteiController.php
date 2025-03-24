<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kentei;

class KenteiController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function index() {
        $user = $this->user;
        $user_ids = Session::get('target_students', null); //セッションから対象の生徒を取得。
        $user_ids = Arr::wrap($user_ids); //配列に統一
        $kenteis = Kentei::whereIn('kenteis.user_id', $user_ids)
            ->LeftJoin('users', 'users.id', '=', 'kenteis.user_id')
            ->selectRaw('
                kenteis.*,
                ROUND(100 * kenteis.first_score / kenteis.first_point) as first_rate,
                ROUND(100 * kenteis.second_score / kenteis.second_point) as second_rate,
                users.name as user_name
            ')
            ->orderBy('first_date','desc')
            ->get();
        return view('kentei.index',compact('user','kenteis'));
    }

    public function create() {
        $user = $this->user;
        return view('kentei.create',compact('user'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'grade' => 'required',
            'first_date' => 'nullable',
            'second_date' => 'nullable',
            'first_score' => 'nullable',
            'second_score' => 'nullable',
            'first_point' => 'nullable',
            'second_point' => 'nullable',
            'result' => 'nullable',
            'memo' => 'nullable', 
        ]);
        $validated['user_id'] = $this->user->id;
        $kentei = Kentei::create($validated);
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Kentei $kentei) {
        $user = $this->user;
        return view('kentei.edit', compact('kentei','user'));
    }

    public function update(Request $request, Kentei $kentei) {
        $validated = $request->validate([
            'name' => 'required',
            'grade' => 'required',
            'first_date' => 'nullable',
            'second_date' => 'nullable',
            'first_score' => 'nullable',
            'second_score' => 'nullable',
            'first_point' => 'nullable',
            'second_point' => 'nullable',
            'result' => 'nullable',
            'memo' => 'nullable', 
        ]);
        $validated['user_id'] = $this->user->id;
        
        $kentei->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }
}

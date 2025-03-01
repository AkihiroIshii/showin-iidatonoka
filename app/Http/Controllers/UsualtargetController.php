<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Traits\UserTrait;
use App\Models\School;
use App\Models\Usualtarget;
use App\Traits\UsualtargetTrait;
use Carbon\Carbon;

class UsualtargetController extends Controller
{
    use UserTrait;
    use UsualtargetTrait;

    public function index() {
        //ログインユーザ
        $user = $this->targetUser(Auth::user());

        $lastMonthCoinSum = $this->getLastMonthCoinSum($user);
        $thisMonthCoinSum = $this->getThisMonthCoinSum($user);

        $current_flg = false;
        $usualtargets = $this->getUsualtargets($current_flg);

        return view('usualtarget.index', compact('user','usualtargets','lastMonthCoinSum','thisMonthCoinSum'));
    }

    public function create() {
        $user_id = Session::get('target_students', null);
        $user = User::where('id', $user_id)->first();
        return view('usualtarget.create', compact('user'));
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'content' => 'required',
            'due_date' => 'required'
        ]);

        $today = Carbon::today();

        $user_id = Session::get('target_students');
        $validated['user_id'] = $user_id;
        $validated['set_date'] = $today;

        $usualtarget = Usualtarget::create($validated);

        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Usualtarget $usualtarget) {
        $user = User::where('id', $usualtarget->user_id)->first();
        return view('usualtarget.edit', compact('usualtarget','user'));
    }

    public function update(Request $request, Usualtarget $usualtarget) {

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
}

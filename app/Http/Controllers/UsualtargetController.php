<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Coin;
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
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function index() {
        //ログインユーザ
        // $user = $this->targetUser(Auth::user());
        $user = $this->user;

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
        // 更新前のコインの値を取得
        $usualtarget_old_coin = Usualtarget::where('id', $usualtarget->id)->value('coin');
        // $usualtarget_old_coin = $usualtarget->value('coin');

        // 日々の目標を更新
        $validated = $request->validate([
            'content' => 'required',
            'due_date' => 'required',
            'achieve_flg' => 'nullable|boolean',
            'coin' => 'nullable|integer',
            'comment' => 'nullable'
        ]);

        $usualtarget->update($validated);

        //コインを新たに付与する場合、コインテーブルにも追加。
        if(is_null($usualtarget_old_coin) && !is_null($validated['coin'])) {
            $user_id = Session::get('target_students', null);
            // $user = User::where('id', $user_id)->first();
            Coin::create([
                'user_id' => $user_id,
                'coin' => $validated['coin'],
                'memo' => '目標ボーナス',
                'change_date' => Carbon::today(), 
            ]);
        }

        $request->session()->flash('message', '更新しました');
        return back();

    }
}

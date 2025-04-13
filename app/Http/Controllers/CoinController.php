<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Coin;
use App\Models\User;

class CoinController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function index() {
        //ログインユーザ
        $user = $this->user;
        $coins = Coin::where('user_id', $user->id)
            ->orderBy('change_date')->get();
        $allCoins = Coin::where('user_id', $user->id)
            ->sum('coin');
        return view('coin.index', compact('user', 'coins', 'allCoins'));
    }

    public function create() {
        $user = $this->user;
        return view('coin.create', compact('user'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            // 'user_id' => 'required',
            'coin' => 'required',
            'memo' => 'required',
            'change_date' => 'required'
        ]);
        $today = Carbon::today();
        $validated['user_id'] = $this->user->id;
        $coin = Coin::create($validated);
        $request->session()->flash('message', '登録しました');
        return back();
    }

    public function edit(Coin $coin) {
        $user = $this->user;
        return view('coin.edit', compact('coin','user'));
    }

    public function update(Request $request, Coin $coin) {
        $validated = $request->validate([
            // 'user_id' => 'required',
            'coin' => 'required',
            'memo' => 'required',
            'change_date' => 'required'
        ]);
        $validated['user_id'] = $this->user->id;
        $coin->update($validated);
        $request->session()->flash('message', '更新しました');
        return back();

    }
}

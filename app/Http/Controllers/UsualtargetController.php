<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Usualtarget;
use Carbon\Carbon;

class UsualtargetController extends Controller
{
    public function index() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->first();

        //普段の目標も表示するため取得
        $today = Carbon::today();
        $usualtargets = Usualtarget::where('user_id', auth()->id())
            ->selectRaw("
                user_id,
                DATE_FORMAT(set_date, '%c/%e') as formatted_set_date,
                DATE_FORMAT(due_date, '%c/%e') as formatted_due_date,
                content,
                IF(
                    achieve_flg = 1,
                    '目標達成！(^^)/◎',
                    IF(
                        due_date < ?,
                        '期限切れ(´・ω・｀)',
                        '挑戦中'
                    )
                ) as achieve_mark,
                comment,
                coin
            ", [$today])
            ->get();

        return view('usualtarget.index', compact('user','usualtargets'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
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
        // $user = User::where('id', auth()->id())->first();
        $user = $this->targetUser(Auth::user());

        // $usualtargets = $this->getUsualtargets($user);

        $lastMonthCoinSum = $this->getLastMonthCoinSum($user);
        $thisMonthCoinSum = $this->getThisMonthCoinSum($user);

        // 追加分
        $user_ids = Session::get('target_students', null); //セッションから対象の生徒を配列で取得。
        if ($user_ids !== null) {
            $usualtargets = $this->getUsualtargets($user_ids);
        } else {
            $usualtargets = $this->getUsualtargets($user);
        }

        return view('usualtarget.index', compact('user','usualtargets','lastMonthCoinSum','thisMonthCoinSum'));
    }
}

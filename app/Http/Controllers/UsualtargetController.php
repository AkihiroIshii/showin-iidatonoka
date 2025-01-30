<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        $usualtargets = $this->getUsualtargets($user);

        $lastMonthCoinSum = $this->getLastMonthCoinSum($user);
        $thisMonthCoinSum = $this->getThisMonthCoinSum($user);

        return view('usualtarget.index', compact('user','usualtargets','lastMonthCoinSum','thisMonthCoinSum'));
    }
}

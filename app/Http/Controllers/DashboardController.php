<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Event;
use App\Models\Usualtarget;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Hash;
use App\Traits\EventTrait;
use App\Traits\UsualtargetTrait;

class DashboardController extends Controller
{
    use EventTrait;
    use UsualtargetTrait;

    public function index() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->first();

        // イベントを取得
        $events = $this->getEvents();

        //普段の目標
        $current_flg = true;
        $usualtargets = $this->getUsualtargets($current_flg);

        return view('dashboard', compact('user','events','usualtargets'));
    } 
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Event;
use App\Models\Information;
use App\Models\Usualtarget;
use App\Models\TopChoice;
use App\Traits\EventTrait;
use App\Traits\UsualtargetTrait;
use App\Traits\TopChoiceTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use EventTrait;
    use UsualtargetTrait;
    use TopChoiceTrait;

    public function index() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->first();

        //志望校
        $top_choices = $this->get_top_choices();

        //普段の目標
        $current_flg = true;
        $usualtargets = $this->getUsualtargets($current_flg);

        //課題（管理者かつダッシュボードであれば全生徒の課題を抽出）
        if (request()->routeIs('dashboard') && Auth::user()->role == 'admin') {
            $kadais = $this->getKadaiAllUsers();
        } else {
            $kadais = $this->getKadai();
        }

        // イベントを取得
        $events = $this->getEvents();
        
        // お知らせを取得
        $informations = Information::query()
            ->orderBy('updated_at','desc')
            ->get();

        return view('dashboard', compact('user','top_choices','events','usualtargets','kadais','informations'));
    } 
}

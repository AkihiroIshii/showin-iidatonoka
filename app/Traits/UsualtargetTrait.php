<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Usualtarget;
use Carbon\Carbon;

trait UsualtargetTrait
{
    /** 日々の目標の一覧取得 */
    public function getUsualtargets($current_flg) {
        //普段の目標も表示するため取得
        $today = Carbon::today();

        $user_ids = Session::get('target_students', null); //セッションから対象の生徒を取得。
        $user_ids = Arr::wrap($user_ids); //配列に統一

        $usualtargets = Usualtarget::whereIn('usualtargets.user_id', $user_ids)
            ->leftJoin('users', function($join) {
                $join->on('usualtargets.user_id', '=', 'users.id');
            })
            ->selectRaw("
                usualtargets.id,
                users.name,
                DATE_FORMAT(usualtargets.set_date, '%c/%e') as formatted_set_date,
                DATE_FORMAT(usualtargets.due_date, '%c/%e') as formatted_due_date,
                usualtargets.content,
                usualtargets.achieve_flg,
                IF(
                    usualtargets.achieve_flg = 1,
                    '目標達成！(^^)/◎',
                    IF(
                        usualtargets.due_date < ?,
                        '期限切れ(´・ω・｀)',
                        '挑戦中'
                    )
                ) as achieve_mark,
                usualtargets.comment,
                usualtargets.coin
            ", [$today]);

        // 挑戦中の目標のみに絞り込む
        if($current_flg == true) {
            $usualtargets = $usualtargets
                ->where('due_date', '>=', $today)
                ->whereNull('achieve_flg');
        }

        $usualtargets = $usualtargets
            ->orderBy('usualtargets.due_date','desc')
            ->orderBy('usualtargets.set_date','desc')
            ->get();

        return $usualtargets;
    }

    // 本日が期限でかつ仕掛かり中の目標を取得
    public function getTargetsByToday()
    {
        $today = Carbon::today();
        $usualtargets = Usualtarget::where('due_date', '=', $today)
            ->whereNull('achieve_flg') //仕掛かり中
            ->leftJoin('users', function($join) {
                $join->on('usualtargets.user_id', '=', 'users.id');
            })
            ->selectRaw('
                users.name,
                usualtargets.content,
                usualtargets.due_date
            ')
            ->get();

        return $usualtargets;
    }

    /** 先月の獲得コイン数取得 */
    public function getLastMonthCoinSum($user) {
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
    
        $coinSum = Usualtarget::where('user_id', $user->id)
            ->whereBetween('due_date', [$startOfLastMonth, $endOfLastMonth])
            ->sum('coin');
    
        return $coinSum;
    }

    /** 今月の獲得コイン数取得 */
    public function getThisMonthCoinSum($user) {
        $startOfThisMonth = Carbon::now()->startOfMonth();
        $endOfThisMonth = Carbon::now()->endOfMonth();
    
        $coinSum = Usualtarget::where('user_id', $user->id)
            ->whereBetween('due_date', [$startOfThisMonth, $endOfThisMonth])
            ->sum('coin');
    
        return $coinSum;
    }
}

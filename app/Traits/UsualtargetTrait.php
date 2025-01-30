<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usualtarget;
use Carbon\Carbon;

trait UsualtargetTrait
{
    /** 日々の目標の一覧取得 */
    public function getUsualtargets($user) {
        //普段の目標も表示するため取得
        $today = Carbon::today();
        $usualtargets = Usualtarget::where('user_id', $user->id)
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
            ->orderBy('set_date','desc')
            ->orderBy('due_date','asc')
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

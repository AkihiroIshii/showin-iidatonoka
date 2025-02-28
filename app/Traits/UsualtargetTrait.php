<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usualtarget;
use Carbon\Carbon;

trait UsualtargetTrait
{
    // /** 日々の目標の一覧取得 */
    // public function getUsualtargets($user) {
    //     //普段の目標も表示するため取得
    //     $today = Carbon::today();
    //     $usualtargets = Usualtarget::where('user_id', $user->id)
    //         ->selectRaw("
    //             id,
    //             user_id,
    //             DATE_FORMAT(set_date, '%c/%e') as formatted_set_date,
    //             DATE_FORMAT(due_date, '%c/%e') as formatted_due_date,
    //             content,
    //             achieve_flg,
    //             IF(
    //                 achieve_flg = 1,
    //                 '目標達成！(^^)/◎',
    //                 IF(
    //                     due_date < ?,
    //                     '期限切れ(´・ω・｀)',
    //                     '挑戦中'
    //                 )
    //             ) as achieve_mark,
    //             comment,
    //             coin
    //         ", [$today])
    //         ->orderBy('set_date','desc')
    //         ->orderBy('due_date','asc')
    //         ->get();

    //     return $usualtargets;
    // }

    /** 日々の目標の一覧取得 */
    public function getUsualtargets($user_ids) {
        //普段の目標も表示するため取得
        $today = Carbon::today();

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
            ", [$today])
            ->orderBy('usualtargets.set_date','desc')
            ->orderBy('usualtargets.due_date','asc')
            ->get();

        // $results = [];
        // foreach($user_ids as $user_id) {
        //     $results += $usualtargets->where('user_id', $user_id)->toArray();
        // }
      
        // $usualtargets->groupBy('user_id');
        // dd($usualtargets);

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

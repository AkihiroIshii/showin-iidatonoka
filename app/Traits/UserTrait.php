<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

// use Carbon\Carbon;

trait UserTrait
{
    public function getUsers() {
        
        // 未達成の目標のうち、もっとも日付が前の１件をユーザごとに取得
        $subQuery = DB::table('usualtargets as ut1')
        ->select('ut1.*')
        ->whereNull('ut1.achieve_flg')
        ->whereRaw('ut1.id = (
            SELECT ut2.id FROM usualtargets as ut2
            WHERE ut2.user_id = ut1.user_id AND ut2.achieve_flg IS NULL
            ORDER BY ut2.due_date ASC
            LIMIT 1
        )');

        // ユーザ一覧を取得
        $users = User::where('grade', '!=', '保護者')
            // ->whereNull('expiration_date')
            ->leftJoin('schools', function($join) {
                $join->on('users.school_id', '=', 'schools.id');
            })
            ->leftJoinSub($subQuery, 'ut', function($join) {
                $join->on('users.id', '=', 'ut.user_id');
            })
            ->selectRaw('
                users.id,
                users.name as user_name,
                schools.name as school_name,
                users.grade,
                users.plan,
                users.expiration_date,
                ut.content,
                ut.due_date
            ')
            ->orderBy('users.expiration_date','asc')
            ->orderBy('users.grade','desc')
            ->orderBy('users.user_id','asc')
            ->orderBy('schools.name','asc')
            ->get();

        return $users;
    }

    public function targetUser($user) {
        // ログインユーザーを取得
        $loggedInUser = Auth::user();

        // 管理者なら引数のユーザー情報を取得
        if ($loggedInUser->role === 'admin' && $user) {
            return $user; // 管理者なら引数のユーザー情報を返す
        }

        // 一般ユーザーなら自分自身の情報を取得
        return $loggedInUser;
    }
}

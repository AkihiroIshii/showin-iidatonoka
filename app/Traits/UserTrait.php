<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

trait UserTrait
{
    public function getUsers() {
        $users = User::where('grade', '!=', '保護者')
            // ->whereNull('expiration_date')
            ->leftJoin('schools', function($join) {
                $join->on('users.school_id', '=', 'schools.id');
            })
            ->selectRaw('
                users.id,
                users.name as user_name,
                schools.name as school_name,
                users.grade,
                users.plan
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

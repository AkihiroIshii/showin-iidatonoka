<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

trait UserTrait
{
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

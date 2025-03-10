<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\TopChoice;

trait TopChoiceTrait
{
    public function get_top_choices() {
        $user_ids = Session::get('target_students', null); //セッションから対象の生徒を取得。
        $user_ids = Arr::wrap($user_ids); //配列に統一
        $top_choices = TopChoice::whereIn('student_id', $user_ids)
            ->LeftJoin('users', 'users.id', '=', 'top_choices.student_id')
            ->orderBy('users.id','asc')
            ->orderBy('exam_date','asc')
            ->orderBy('desired_ranking','asc')
            ->get();
        return $top_choices;
    }
}

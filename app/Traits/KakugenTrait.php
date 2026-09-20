<?php

namespace App\Traits;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Arr;
use App\Models\Kakugen;
use Carbon\Carbon;

trait KakugenTrait
{
    /** 日々の目標の一覧取得 */
    public function getKakugen() {
        //普段の目標も表示するため取得
        // $today = Carbon::today();

        $kakugen = Kakugen::inRandomOrder()->first();
        return $kakugen;
    }
}

<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\School;
use App\Models\Event;
use Carbon\Carbon;

trait EventTrait
{
    public function getEvents() {
        $startDate = Carbon::today()->startOfDay();
        $endDate = Carbon::today()->addMonth(2)->endOfDay();  //２か月後

        $user_ids = Arr::wrap(Session::get('target_students'));
        $school_ids = User::whereIn('id', $user_ids)->pluck('school_id')->toArray();
        $school_ids = array_merge($school_ids, [901, 902]); //松陰塾と外部のIDを追加。

        // 直近２ヵ月のイベントを取得
        $events = Event::whereBetween('events.date_from', [$startDate, $endDate])
        ->leftJoin('schools', function ($join) {
            $join->on('events.school_id', '=', 'schools.id');
        })
        ->selectRaw("
            events.*,
            schools.name,
            IF(events.date_from = events.date_to,
                DATE_FORMAT(events.date_from, '%c/%e'),
                CONCAT(
                    CONCAT(DATE_FORMAT(events.date_from, '%c/%e'), '～'),
                    DATE_FORMAT(events.date_to, '%c/%e')
                )
            ) as formatted_date
        ");

        // 生徒に関連する学校のイベントに絞り込み。
        if(Auth::user()->role !== "admin") {
            $events = $events->whereIn('school_id', $school_ids);
        }
        $events = $events->get();
        return $events;
    }
}

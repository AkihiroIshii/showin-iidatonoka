<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index() {
        //ログインユーザ
        $user = User::where('id', auth()->id())->first();

        $startDate = Carbon::today()->startOfDay();
        $endDate = Carbon::today()->addMonth(2)->endOfDay();  //２か月後
        
        //イベント（本日から１か月間）
        $events = Event::where(function ($query) use ($user) {
                $query->where('school_id', $user->school_id)
                      ->orWhere('school_id', 901)  //松陰塾
                      ->orWhere('school_id', 902); //外部
            })
            ->whereBetween('events.date_from', [$startDate, $endDate]) // この条件はANDとして適用される
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
            ")
            ->orderBy('events.date_from', 'asc')
            ->get();
            
        return view('event.index', compact('user','events'));
    }
}

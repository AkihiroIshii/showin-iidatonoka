<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Room;

class RoomController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function video() {
        $room_name = Room::where('user_id', $this->user->id)
            ->pluck('room_name');
        return view('meeting.video', compact('room_name'));
    }

    // public function guest() {
    //     $room_name = Room::where('user_id', $this->user->id)
    //         ->pluck('room_name');
    //     return view('meeting.guest', compact('room_name'));
    // }
}

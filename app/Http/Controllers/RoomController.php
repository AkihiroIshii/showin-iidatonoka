<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Services\JaasTokenService;
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
        $user = $this->user;
        $jwtToken = JaasTokenService::generateToken($room_name, $user);
        // dd($jwtToken);
        return view('meeting.video', compact('room_name', 'jwtToken', 'user'));
    }

    // public function joinRoom($roomName)
    // {
    //     $user = Auth::user();
    //     $jwtToken = JaasTokenService::generateToken($roomName, $user);

    //     return view('jitsi.room', compact('roomName', 'jwtToken'));
    // }
}

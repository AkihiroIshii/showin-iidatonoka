<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Link;
use App\Models\User;

class LinkController extends Controller
{
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
        $this->user_ids = Arr::wrap(Session::get('target_students'));
        $this->user_grades = User::whereIn('id', $this->user_ids)->pluck('grade')->toArray();
    }

    public function index(){
        // dd($this->user_grades);
        // $user_grade = User::where('id', $this->user->id)->pluck('grade');
        // dd($user_grade);
        $user_grades = $this->user_grades;
        if(Auth::user()->role == "admin") {
            $links = Link::orderBy('display_order','asc')->get();
        } else {
            $links = Link::where(function($query) use ($user_grades) {
                foreach ($user_grades as $grade) {
                    $query->orWhere('grade', 'like', '%' . $grade . '%');
                }
            })
            ->orWhereNull('grade')
            ->orderBy('display_order','asc')
            ->get();
        }
        return view('link', compact('links'));
    }
}

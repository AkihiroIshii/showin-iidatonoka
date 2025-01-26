<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gift;
use App\Models\Howtogetcoin;

class GiftController extends Controller
{
    public function index() {
        $gifts = Gift::orderBy('coin','desc')
            ->get();

        return view('gift.index', compact('gifts'));
    }

    public function howtoget() {
        $user = User::where('id', auth()->id())->first();

        $howtogetcoins = Howtogetcoin::where('howtogetcoins.grade', 'like', "%{$user->grade}%")
            ->get();

        return view('gift.howtoget', compact('howtogetcoins'));
    }
}

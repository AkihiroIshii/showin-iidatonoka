<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $informations = Information::latest()->take(3)->get();
        return view('auth.login', compact('informations'));
    }
}

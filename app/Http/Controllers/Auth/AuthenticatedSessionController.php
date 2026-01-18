<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Family;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $today = Carbon::today()->toDateString();

        if (Auth::user() == null) {
            return redirect()->route('login');
        }
        if(Auth::user()->expiration_date != null & Auth::user()->expiration_date < $today) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            $errMsg = '退塾した生徒はログインできません。';

            // return redirect('/');
            return redirect('login')->with('errMsg', $errMsg);
            dd($errMsg);
        }

        /*保護者の場合、閲覧対象のユーザ（生徒）をセッションに保存*/
        if (Auth::user()->grade == '保護者') {
            $target_students = Family::where('parent_id', Auth::user()->id)
                ->orderBy('student_id','asc')
                ->pluck('student_id')
                ->toArray();
  
            Session::put('target_students', $target_students);
            // $request->session()->put('target_students', $target_students);
        } else {
            // 保護者以外は、自分のIDを対象ユーザとしてセッションに保存
            Session::put('target_students', Auth::user()->id);
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.students');
        }
        return redirect()->intended(route('usualtarget', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // return redirect('/');
        return redirect('login');
    }
}

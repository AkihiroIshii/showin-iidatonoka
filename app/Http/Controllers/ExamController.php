<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Traits\ExamTrait;
use App\Models\User;

class ExamController extends Controller
{
    use ExamTrait;
    private $user;

    public function __construct()
    {
        // セッション情報から対象生徒を取得
        $this->user = User::where('id', Session::get('target_students'))->first();
    }

    public function index() {
        $user = User::where('id', $this->user->id)->first();
        $examresults = $this->getExamResults($user);
        return view('exam.index', compact('user','examresults'));
    }
}

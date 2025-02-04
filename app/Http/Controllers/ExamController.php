<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ExamTrait;
use App\Models\User;

class ExamController extends Controller
{
    use ExamTrait;

    public function index() {
        $user = User::where('id', auth()->id())->first();
        $examresults = $this->getExamResults($user);
        return view('exam.index', compact('examresults'));
    }
}

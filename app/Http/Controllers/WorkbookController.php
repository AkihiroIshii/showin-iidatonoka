<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\UserTrait;
use App\Models\Workbook;

class WorkbookController extends Controller
{
    use UserTrait;

    public function reference() {
        return view('workbook.reference');
    }

    public function grammar() {
        return view('workbook.grammar');
    }

    public function reading() {
        return view('workbook.reading');
    }

    public function answersheet() {
        return redirect(asset('pdf/answersheet.pdf'));
    }

    public function index(User $user) {
        $user = $this->targetUser(Auth::user());

        $workbooks = Workbook::all();

        return view('workbook.index', compact('user','workbooks'));
    }
}

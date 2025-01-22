<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkbookController extends Controller
{
    public function reference() {
        return view('workbook.reference');
    }

    public function grammar() {
        return view('workbook.grammar');
    }

    public function answersheet() {
        return redirect(asset('pdf/answersheet.pdf'));
    }
}

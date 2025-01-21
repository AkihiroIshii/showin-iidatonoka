<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkbookController extends Controller
{
    public function reference() {
        return view('workbook.reference');
    }
}

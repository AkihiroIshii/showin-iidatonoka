<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ExamratioTrait;

class ExamratioController extends Controller
{
    use ExamratioTrait;

    /** 入試倍率（高校入試） */
    public function index() {
        //高校入試倍率一覧を取得
        $examratios = $this->getExamRatios();

        return view('examratio.index', compact('examratios'));
    }

    // public function school() {
    //     $examratios = $this->getExamRatios();

    //     return view('examratio.school', compact('examratios'));
    // }
}

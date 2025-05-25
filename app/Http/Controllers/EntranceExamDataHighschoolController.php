<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\EntranceExamDataHighschoolTrait;

class EntranceExamDataHighschoolController extends Controller
{
    use EntranceExamDataHighschoolTrait;

    /** 入試倍率（年度別） */
    public function years() {
        //高校入試倍率一覧を取得
        $entrance_exam_data_highschools = $this->getEntranceExamDataHighschools();
        $grouped_entrance_exam_data_highschools = $entrance_exam_data_highschools->groupBy('year');
        return view('entrance_exam_data_highschool.years', compact('grouped_entrance_exam_data_highschools'));
    }

    /** 入試倍率（高校別） */
    public function schools() {
        //高校入試倍率一覧を取得
        $entrance_exam_data_highschools = $this->getEntranceExamDataHighschools();
        $grouped_entrance_exam_data_highschools = $entrance_exam_data_highschools
            ->groupBy('schoolName') // 学校ごとにまとめる
            ->map(function ($departments) {
                return $departments->groupBy('department'); // 学科ごとにまとめる
            });
        // dd($grouped_entrance_exam_data_highschools);
        return view('entrance_exam_data_highschool.schools', compact('grouped_entrance_exam_data_highschools'));
    }
}

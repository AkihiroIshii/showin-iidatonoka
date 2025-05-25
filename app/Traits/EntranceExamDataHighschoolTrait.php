<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\EntranceExamDataHighschool;

trait EntranceExamDataHighschoolTrait
{
    public function getEntranceExamDataHighschools() {
        //高校入試倍率一覧を取得
        $entrance_exam_data_highschools = EntranceExamDataHighschool::query()
            ->leftJoin('schools', function($join) {
                $join->on('entrance_exam_data_highschools.school_id', '=', 'schools.id');
            })
            ->selectRaw('
                entrance_exam_data_highschools.*,
                IF(entrance_exam_data_highschools.rerecruitment = -1, "若干名", entrance_exam_data_highschools.rerecruitment) as formatted_rerecruitment,
                schools.name as schoolName,
                schools.shortname as schoolNameShort,
                CONCAT(schools.name, "（", entrance_exam_data_highschools.department, "）") as school_department,
                ROUND(entrance_exam_data_highschools.early_applicants/entrance_exam_data_highschools.early_capacity, 2) as early_ratio,
                ROUND(entrance_exam_data_highschools.late_post_applicants/entrance_exam_data_highschools.late_capacity, 2) as late_ratio
            ')
            ->orderBy('year','desc')
            ->orderBy('school_id','asc')
            // ->orderBy('period','asc')
            // ->orderBy('type','asc')
            ->get();

        return $entrance_exam_data_highschools;
    }
}

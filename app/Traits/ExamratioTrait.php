<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Examratio;

trait ExamratioTrait
{
    public function getExamRatios() {
        //高校入試倍率一覧を取得
        $examratios = Examratio::query()
            // ->where('num_capacity', '>', 0)
            ->leftJoin('schools', function($join) {
                $join->on('examratios.school_id', '=', 'schools.id');
            })
            ->selectRaw('
                examratios.*,
                schools.name as schoolName,
                ROUND(examratios.num_applicants/examratios.num_capacity, 1) as examRatio
            ')
            ->orderBy('school_id','asc')
            ->orderBy('period','asc')
            ->orderBy('year','desc')
            ->orderBy('type','asc')
            ->get();

        return $examratios;
    }
}

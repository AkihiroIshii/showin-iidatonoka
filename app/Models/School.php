<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function exams() {
        return $this->hasMany(Exam::class);
    }

    public function entrance_exam_data_highschools() {
        return $this->hasMany(EntranceExamDataHighschool::class);
    }

    // public function examratios() {
    //     return $this->hasMany(Examratio::class);
    // }
}

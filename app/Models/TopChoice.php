<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopChoice extends Model
{
    protected $fillable = [
        'student_id',
        'school_name',
        'department',
        'desired_ranking',
        'selection_method',
        'exam_date',
        'subjects',
        'mock_date',
        'mock_name',
        'mock_judge',
        'memo',
        'num_capacity',
    ];
}

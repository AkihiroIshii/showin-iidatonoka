<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workrecord extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'subject',
        'work_name',
        'work_range',
        'memo',
        'date_1st',
        'date_2nd',
        'date_3rd',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}

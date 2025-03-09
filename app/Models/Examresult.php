<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examresult extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'score_japanese',
        'score_society',
        'score_math',
        'score_science',
        'score_english',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}

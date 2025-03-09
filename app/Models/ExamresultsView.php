<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamresultsView extends Model
{
    use HasFactory;

    protected $table = 'examresults_view';
    public $timestamps = false; // ビューには通常 created_at, updated_at は不要

    // protected $fillable = [
    //     'id', 'user_id', 'exam_id', 'score_japanese', 'score_math', 'exam_date', 'exam_name'
    // ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'school_id',
        'year',
        'grade', 
        'no', 
        'exam_date',
        'exam_name',
        'avg_japanese',
        'avg_society',
        'avg_math', 
        'avg_science',
        'avg_english',
    ];
    
    public function school() {
        return $this->belongsTo(School::class);
    }
}

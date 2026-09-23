<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workbook extends Model
{
    protected $fillable = [
        'id',
        'subject',
        'field',
        'q_type',
        'unit',
        'grade',
        'term',
        'question',
        'answer',
        'explanation',
        'reference',
    ];
}

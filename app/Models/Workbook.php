<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workbook extends Model
{
    protected $fillable = [
        'id',
        'subject',
        'field',
        'grade',
        'question',
        'answer',
        'reference',
    ];
}

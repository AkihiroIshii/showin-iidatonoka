<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kentei extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'grade',
        'first_date',
        'second_date',
        'first_score',
        'second_score',
        'first_point',
        'second_point',
        'result',
        'memo', 
    ];
}

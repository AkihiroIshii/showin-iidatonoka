<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kakugen extends Model
{
    protected $fillable = [
        'sentence',
        'person',
        'reference',
        'comment',
    ];
}

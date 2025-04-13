<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'coin',
        'memo',
        'change_date', 
    ];
}

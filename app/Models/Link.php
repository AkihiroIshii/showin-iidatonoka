<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'id',
        'title',
        'link',
        'admin_link',
        'grade',
        'memo',
    ];
}

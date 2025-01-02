<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'subject',
        'no',
        'target_score',
        'target_minute',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

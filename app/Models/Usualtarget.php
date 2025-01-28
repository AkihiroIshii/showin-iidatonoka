<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usualtarget extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    // 一括代入可能な属性を指定
    protected $fillable = ['user_id', 'set_date', 'due_date', 'content', 'coin', 'comment', 'achieve_flg'];
}

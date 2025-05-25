<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examratio extends Model
{
    public function school() {
        return $this->belongsTo(School::class);
    }
}

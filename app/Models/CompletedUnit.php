<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CompletedUnit extends Model
{
    protected $fillable = [
        'teaching_material',
        'user_id',
        'unit_id_aishowin',
        'num_loop', 
        'unit_id_mojizou',
        'unit_id_kawaijukuone',
        'target_date', 
        'completed_date', 
        'memo',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}

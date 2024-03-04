<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $table = 'works';
    protected $fillable = ['user_id','start_time','end_time','work_time','date'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stops()
    {
        return $this->hasMany(Stop::class);
    }

    
}

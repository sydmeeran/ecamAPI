<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
      'title', 'from', 'to', 'description', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupChat extends Model
{
    use SoftDeletes;

    protected $table = 'group_chats';

    protected $fillable = [
        'sender_id',
        'message',
        'assigned_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'sender_id');
    }
}

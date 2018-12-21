<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annual extends Model
{
    protected $table = 'annual';

    protected $fillable = [
        'month', 'quotation_id'
    ];
}

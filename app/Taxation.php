<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxation extends Model
{
    protected $table = 'taxation';

    protected $fillable = [
        'type', 'value', 'months', 'years', 'quotation_id'
    ];
}

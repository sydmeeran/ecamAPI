<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditing extends Model
{
    protected $table = 'auditing';

    protected $fillable = [
        'type', 'value', 'months', 'years', 'quotation_id'
    ];
}

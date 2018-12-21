<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulting extends Model
{
    protected $table = 'consulting';

    protected $fillable = [
        'company_type', 'value', 'quotation_id'
    ];
}

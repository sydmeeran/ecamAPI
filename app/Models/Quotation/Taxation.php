<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxation extends Model
{
    protected $table = 'taxation';

    protected $fillable = [
        'type', 'value', 'months', 'years', 'quotation_id', 'invoice_id'
    ];

    public function quotation(){
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}

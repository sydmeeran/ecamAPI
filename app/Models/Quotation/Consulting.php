<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulting extends Model
{
    protected $table = 'consulting';

    protected $fillable = [
        'license_type', 'value', 'quotation_id', 'invoice_id'
    ];
    public function quotation(){
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

}

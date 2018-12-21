<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingService extends Model
{
    protected $table = 'accounting_service';

    protected $fillable = [
        'type', 'value', 'months', 'years', 'quotation_id'
    ];

    public function quotation(){
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }
}

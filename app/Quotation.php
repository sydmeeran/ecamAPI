<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotation';

    protected $fillable = [
        'customer_id', 'business_id', 'sub_total', 'discount', 'tax', 'total'
    ];

    public function accounting_service(){
        return $this->hasOne(AccountingService::class);
    }
}

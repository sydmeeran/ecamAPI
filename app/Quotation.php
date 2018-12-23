<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';

    protected $fillable = [
        'customer_id', 'business_id', 'sub_total', 'discount', 'tax', 'total'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function business(){
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function accounting_service(){
        return $this->hasOne(AccountingService::class);
    }

    public function auditing(){
        return $this->hasOne(Auditing::class);
    }

    public function consulting(){
        return $this->hasOne(Consulting::class);
    }

    public function taxation(){
        return $this->hasOne(Taxation::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
}

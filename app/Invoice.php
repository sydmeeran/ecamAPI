<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'quotation_id', 'customer_id', 'business_id', 'sub_total', 'discount', 'tax', 'total'
    ];

    public function quotation(){
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function business(){
        return $this->belongsTo(Business::class, 'business_id');
    }
}

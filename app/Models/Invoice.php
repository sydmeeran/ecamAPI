<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'invoice_id', 'member_id', 'business_id', 'member_type', 'payment_type', 'payment_date',
    ];

    public function quotation(){
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function business(){
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function receipt(){
        return $this->hasOne(Receipt::class);
    }

    public function remarks(){
        return $this->hasMany(InvoiceRemark::class);
    }
}

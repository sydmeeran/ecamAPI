<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';

    protected $fillable = [
        'receipt_id', 'invoice_id', 'type', 'bank', 'bank_date', 'cash_date', 'description'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceRemark extends Model
{
    protected $table = 'invoice_remarks';

    protected $fillable = [
        'invoice_id', 'remark'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}

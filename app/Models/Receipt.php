<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';

    protected $fillable = [
        'receipt_id', 'invoice_id', 'sponsor_donate_id', 'type', 'bank', 'bank_date', 'cash_date', 'description'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function sponsor_donate(){
        return $this->belongsTo(SponsorDonate::class, 'sponsor_donate_id');
    }

    public function getEmailAttribute(){
        // dd($this->invoice_id);
        if($this->invoice_id){
            return $this->invoice->member->email;
        }
        return $this->sponsor_donate->email;
    }

    public function getCompanyNameAttribute(){
        // dd($this->invoice_id);
        if($this->invoice_id){
            return $this->invoice->member->company_name;
        }
        return $this->sponsor_donate->company_name;
    }

    public function getAmountAttribute(){
        // dd($this->invoice_id);
        if($this->invoice_id){
            return $this->invoice->member->amount;
        }
        return $this->sponsor_donate->amount;
    }

    

}

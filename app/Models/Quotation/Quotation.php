<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';

    protected $fillable = [
        'quotation_id', 'member_id', 'business_id', 'sub_total', 'discount', 'tax', 'total', 'is_active'
    ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
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
        return $this->hasMany(Invoice::class);
    }

    public function active_invoice(){
        return $this->invoice()->where('is_active', 1);
    }
}

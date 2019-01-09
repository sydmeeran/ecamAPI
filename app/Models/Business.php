<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'businesses';

    protected $fillable = [
        'business_name', 'license_no', 'license_type', 'license_photo', 'address', 'customer_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function quotation(){
        return $this->hasMany(Quotation::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

    public function receipt(){
        return $this->hasMany(Receipt::class);
    }
}

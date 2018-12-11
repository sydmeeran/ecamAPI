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
}

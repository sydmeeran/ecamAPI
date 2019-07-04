<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorDonate extends Model
{
    protected $table = 'sponsor_and_donate';

    protected $fillable = [
        'company_name', 'email', 'phone_no', 'event_title', 'amount', 'description', 'type'
    ];

    public function receipt(){
        return $this->hasOne(Receipt::class);
    }
}

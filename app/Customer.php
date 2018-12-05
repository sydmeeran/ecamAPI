<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Model
{
    use Notifiable, HasApiTokens;

    protected $table = 'customers';

    protected $fillable = [
      'business_name', 'license_no', 'license_type', 'address', 'owner_name', 'nrc_no',
        'phone_no', 'email', 'contact_name', 'contact_position', 'contact_number', 'contact_email', 'otp',
        'is_use', 'is_active', 'is_suspend'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
}

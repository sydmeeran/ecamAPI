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
      'name', 'email', 'phone_no', 'address', 'password', 'code', 'is_confirm', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}

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
      'company_id', 'company_name', 'owner_name', 'nrc_no', 'nrc_photo', 'phone_no',
        'email', 'contact_name', 'contact_position', 'contact_number', 'contact_email',
        'company_dica_link', 'company_link', 'otp', 'is_use', 'is_active', 'is_suspend'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token'
    ];

    public function businesses(){
        return $this->hasMany(Business::class);
    }

    public function job_entries(){
        return $this->hasMany(JobEntry::class);
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

    public function pnl_excel(){
        return $this->hasMany(PnlExcel::class);
    }

    public function balance_sheet_excel(){
        return $this->hasMany(BalanceSheetExcel::class);
    }

}

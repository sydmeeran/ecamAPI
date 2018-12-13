<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobEntry extends Model
{
    protected $table = 'job_entries';

    protected $fillable = [
      'type', 'company_type', 'excel_type', 'excel_file', 'customer_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function pnl_excel(){
        return $this->hasMany(PnlExcel::class);
    }

    public function balance_sheet_excel(){
        return $this->hasMany(BalanceSheetExcel::class);
    }
}

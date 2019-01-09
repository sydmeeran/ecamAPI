<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobEntry extends Model
{
    protected $table = 'job_entries';

    protected $fillable = [
      'type', 'start_date', 'end_date', 'company_type', 'excel_type', 'excel_file', 'customer_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function pnl_excel(){
        return $this->hasOne(PnlExcel::class);
    }

    public function pnl_excel_data(){
        return $this->pnl_excel()->with(['pnl_debit', 'pnl_credit', 'pnl_variation']);
    }

    public function balance_sheet_excel(){
        return $this->hasOne(BalanceSheetExcel::class);
    }

    public function balance_sheet_excel_data(){
        return $this->balance_sheet_excel()->with(['balance_sheet_amount_1', 'balance_sheet_amount_2', 'balance_sheet_variation']);
    }
}

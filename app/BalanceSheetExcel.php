<?php

namespace App;

use App\Models\BalanceSheetExcel\Amount1;
use App\Models\BalanceSheetExcel\Amount2;
use App\Models\BalanceSheetExcel\Variation;
use Illuminate\Database\Eloquent\Model;

class BalanceSheetExcel extends Model
{
    protected $table = 'balance_sheet_excel';

    protected $fillable = [
        'balance_sheet_amount_1_id', 'balance_sheet_amount_2_id', 'balance_sheet_variation_id', 'job_entry_id', 'customer_id'
    ];

    public function job_entry(){
        return $this->belongsTo(JobEntry::class, 'job_entry_id');
    }

    public function balance_sheet_amount_1(){
        return $this->belongsTo(Amount1::class, 'balance_sheet_amount_1_id');
    }

    public function balance_sheet_amount_2(){
        return $this->belongsTo(Amount2::class, 'balance_sheet_amount_2_id');
    }

    public function balance_sheet_variation(){
        return $this->belongsTo(Variation::class, 'balance_sheet_variation_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

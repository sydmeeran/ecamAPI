<?php

namespace App;

use App\Models\PnlExcel\Credit;
use App\Models\PnlExcel\Debit;
use App\Models\PnlExcel\Variation;
use Illuminate\Database\Eloquent\Model;

class PnlExcel extends Model
{
    protected $table = 'pnl_excel';

    protected $fillable = [
        'pnl_debit_id', 'pnl_credit_id', 'pnl_variation_id', 'job_entry_id', 'customer_id'
    ];

    public function job_entry(){
        return $this->belongsTo(JobEntry::class, 'job_entry_id');
    }

    public function pnl_debit(){
        return $this->belongsTo(Debit::class, 'pnl_debit_id');
    }

    public function pnl_credit(){
        return $this->belongsTo(Credit::class, 'pnl_credit_id');
    }

    public function pnl_variation(){
        return $this->belongsTo(Variation::class, 'pnl_variation_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

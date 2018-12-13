<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetExcel extends Model
{
    protected $table = 'balance_sheet_excel';

    protected $fillable = [
        'var1', 'var2', 'var3', 'job_entry_id'
    ];

    public function job_entry(){
        return $this->belongsTo(JobEntry::class, 'job_entry_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PnlExcel extends Model
{
    protected $table = 'pnl_excel';

    protected $fillable = [
        'var1', 'var2', 'var3', 'job_entry_id'
    ];

    public function job_entry(){
        return $this->belongsTo(JobEntry::class, 'job_entry_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetExcel extends Model
{
    protected $table = 'balance_sheet_excel';

//    protected $casts = [
//        'non_current_assets' => 'array',
//        'total_non_current_assets' => 'array',
//        'current_assets' => 'array',
//        'total_current_assets' => 'array',
//        'total_assets' => 'array',
//        'non_current_liabilities' => 'array',
//        'long_term_loan' => 'array',
//        'non_current_deferred_income' => 'array',
//        'deferred_tax' => 'array',
//        'total_non_current_liabilities' => 'array',
//        'current_liabilities' => 'array',
//        'trade_creditors' => 'array',
//        'current_deferred_income' => 'array',
//        'salary_payable' => 'array',
//        'internet_bill' => 'array',
//        'social_security_fees' => 'array',
//        'electricity_charges' => 'array',
//        'staff_fund' => 'array',
//        'bod_salaries' => 'array',
//        'consultant_salaries' => 'array',
//        'payable_stamp_duty' => 'array',
//        'payable_bonus' => 'array',
//        'bod_consultant_salaries_tax' => 'array',
//        'advance_2_and_5_percent_tax' => 'array',
//        '2_percent_tax' => 'array',
//        '5_percent_commercial_tax' => 'array',
//        'total_current_liabilities' => 'array',
//        'total_liabilities' => 'array',
//        'net_assets' => 'array',
//        'equity' => 'array',
//        'owner_shareholders_equity' => 'array',
//        'capital' => 'array',
//        'total_owner_shareholders_equity' => 'array',
//        'retained_earnings' => 'array',
//        'profit_loss_for_the_year' => 'array',
//        'profit_divided' => 'array',
//        'total_equity' => 'array',
//    ];

    protected $fillable = [
        "non_current_assets", "total_non_current_assets",
        "current_assets", "total_current_assets", "total_assets", "long_term_loan",
        "non_current_deferred_income", "deferred_tax", "total_non_current_liabilities",
        "trade_creditors", "current_deferred_income", "salary_payable", "internet_bill", "social_security_fees",
        "electricity_charges", "staff_fund", "bod_salaries", "consultant_salaries", "payable_stamp_duty",
        "payable_bonus", "bod_consultant_salaries_tax", "advance_2_and_5_percent_tax", "2_percent_tax",
        "5_percent_commercial_tax", "total_current_liabilities", "total_liabilities",
        "net_assets", "equity", "owner_shareholders_equity", "capital", "total_owner_shareholders_equity",
        "retained_earnings", "profit_loss_for_the_year", "profit_divided", "total_equity",
         "job_entry_id", "customer_id"
    ];

    public function job_entry(){
        return $this->belongsTo(JobEntry::class, 'job_entry_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

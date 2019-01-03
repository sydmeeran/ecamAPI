<?php

namespace App\Models\BalanceSheetExcel;

use Illuminate\Database\Eloquent\Model;

class Amount1 extends Model
{
    protected $table = "balance_sheet_amount_1";

    protected $fillable = [
        "non_current_assets", "computer_a_c", "computer_accum_dep", "furniture_fixture",
        "furniture_fixtures_accum_dep", "printer", "printer_accum_dep", "cctv_a_c",
        "cctv_accum_dep", "finger_print", "finger_print_accum_dep", "total_non_current_assets",
        "current_assets", "inventory", "trade_debtors", "cash_in_hand", "petty_cash ",
        "bank_account", "prepaid", "advance_commercial_tax", "adv_income_tax", "advance",
        "total_current_assets", "total_assets", "non_current_liabilities", "long_term_loan",
        "non_current_deferred_income", "deferred_tax", "total_non_current_liabilities", "current_liabilities",
        "trade_creditors", "current_deferred_income", "salary_payable", "internet_bill", "social_security_fees",
        "electricity_charges", "staff_fund", "bod_salaries", "consultant_salaries", "payable_stamp_duty",
        "payable_bonus", "bod_consultant_salaries_tax", "advance_2_and_5_percent_tax", "2_percent_tax",
        "5_percent_commercial_tax", "total_current_liabilities", "total_liabilities",
        "net_assets", "equity", "owner_shareholders_equity", "capital", "total_owner_shareholders_equity",
        "retained_earnings", "profit_loss_for_the_year", "profit_divided", "total_equity"
    ];


    public function balance_sheet_excel(){
        return $this->hasOne('balance_sheet_excel');
    }
}
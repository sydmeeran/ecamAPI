<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceSheetVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_sheet_variation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('non_current_assets')->nullable();
            $table->integer('computer_a_c')->nullable();
            $table->integer('computer_accum_dep')->nullable();
            $table->integer('furniture_fixture')->nullable();
            $table->integer('furniture_fixtures_accum_dep')->nullable();
            $table->integer('printer')->nullable();
            $table->integer('printer_accum_dep')->nullable();
            $table->integer('cctv_a_c')->nullable();
            $table->integer('cctv_accum_dep')->nullable();
            $table->integer('finger_print')->nullable();
            $table->integer('finger_print_accum_dep')->nullable();
            $table->integer('total_non_current_assets')->nullable();
            $table->integer('current_assets')->nullable();
            $table->integer('inventory')->nullable();
            $table->integer('trade_debtors')->nullable();
            $table->integer('cash_in_hand')->nullable();
            $table->integer('petty_cash')->nullable();
            $table->integer('bank_account')->nullable();
            $table->integer('prepaid')->nullable();
            $table->integer('advance_commercial_tax')->nullable();
            $table->integer('adv_income_tax')->nullable();
            $table->integer('advance')->nullable();
            $table->integer('total_current_assets')->nullable();
            $table->integer('total_assets')->nullable();
            $table->integer('non_current_liabilities')->nullable();
            $table->integer('long_term_loan')->nullable();
            $table->integer('non_current_deferred_income')->nullable();
            $table->integer('deferred_tax')->nullable();
            $table->integer('total_non_current_liabilities')->nullable();
            $table->integer('current_liabilities')->nullable();
            $table->integer('trade_creditors')->nullable();
            $table->integer('current_deferred_income')->nullable();
            $table->integer('salary_payable')->nullable();
            $table->integer('internet_bill')->nullable();
            $table->integer('social_security_fees')->nullable();
            $table->integer('electricity_charges')->nullable();
            $table->integer('staff_fund')->nullable();
            $table->integer('bod_salaries')->nullable();
            $table->integer('consultant_salaries')->nullable();
            $table->integer('payable_stamp_duty')->nullable();
            $table->integer('payable_bonus')->nullable();
            $table->integer('bod_consultant_salaries_tax')->nullable();
            $table->integer('advance_2_and_5_percent_tax')->nullable();
            $table->integer('2_percent_tax')->nullable();
            $table->integer('5_percent_commercial_tax')->nullable();
            $table->integer('total_current_liabilities')->nullable();
            $table->integer('total_liabilities')->nullable();
            $table->integer('net_assets')->nullable();
            $table->integer('equity')->nullable();
            $table->integer('owner_shareholders_equity')->nullable();
            $table->integer('capital')->nullable();
            $table->integer('total_owner_shareholders_equity')->nullable();
            $table->integer('retained_earnings')->nullable();
            $table->integer('profit_loss_for_the_year')->nullable();
            $table->integer('profit_divided')->nullable();
            $table->integer('total_equity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_sheet_variation');
    }
}

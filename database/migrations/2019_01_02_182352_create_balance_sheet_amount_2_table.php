<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceSheetAmount2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_sheet_amount_2', function (Blueprint $table) {
            $table->increments('id');
            $table->json('non_current_assets')->nullable();
            $table->integer('total_non_current_assets')->nullable();

            $table->json('current_assets')->nullable();
            $table->integer('total_current_assets')->nullable();
            $table->integer('total_assets')->nullable();

            $table->integer('long_term_loan')->nullable();
            $table->integer('non_current_deferred_income')->nullable();
            $table->integer('deferred_tax')->nullable();
            $table->integer('total_non_current_liabilities')->nullable();

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
        Schema::dropIfExists('balance_sheet_amount_2');
    }
}

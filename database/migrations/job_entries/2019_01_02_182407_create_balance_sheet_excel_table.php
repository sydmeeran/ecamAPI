<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceSheetExcelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_sheet_excel', function (Blueprint $table) {
            $table->increments('id');

            $table->json('non_current_assets')->nullable();
            $table->json('total_non_current_assets')->nullable();

            $table->json('current_assets')->nullable();
            $table->json('total_current_assets')->nullable();
            $table->json('total_assets')->nullable();

            $table->json('long_term_loan')->nullable();
            $table->json('non_current_deferred_income')->nullable();
            $table->json('deferred_tax')->nullable();
            $table->json('total_non_current_liabilities')->nullable();

            $table->json('trade_creditors')->nullable();
            $table->json('current_deferred_income')->nullable();
            $table->json('salary_payable')->nullable();
            $table->json('internet_bill')->nullable();
            $table->json('social_security_fees')->nullable();
            $table->json('electricity_charges')->nullable();
            $table->json('staff_fund')->nullable();
            $table->json('bod_salaries')->nullable();
            $table->json('consultant_salaries')->nullable();
            $table->json('payable_stamp_duty')->nullable();
            $table->json('payable_bonus')->nullable();
            $table->json('bod_consultant_salaries_tax')->nullable();
            $table->json('advance_2_and_5_percent_tax')->nullable();
            $table->json('2_percent_tax')->nullable();
            $table->json('5_percent_commercial_tax')->nullable();
            $table->json('total_current_liabilities')->nullable();
            $table->json('total_liabilities')->nullable();
            $table->json('net_assets')->nullable();
            $table->json('equity')->nullable();
            $table->json('owner_shareholders_equity')->nullable();
            $table->json('capital')->nullable();

            $table->json('total_owner_shareholders_equity')->nullable();
            $table->json('retained_earnings')->nullable();
            $table->json('profit_loss_for_the_year')->nullable();
            $table->json('profit_divided')->nullable();
            $table->json('total_equity')->nullable();

            $table->unsignedInteger('job_entry_id');
            $table->unsignedInteger('member_id');
            $table->timestamps();

            $table->foreign('job_entry_id')->references('id')->on('job_entries')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_sheet_excel');
    }
}

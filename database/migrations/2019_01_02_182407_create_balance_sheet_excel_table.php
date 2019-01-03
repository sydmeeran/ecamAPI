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
            $table->unsignedInteger('balance_sheet_amount_1_id')->nullable();
            $table->unsignedInteger('balance_sheet_amount_2_id')->nullable();
            $table->unsignedInteger('balance_sheet_variation_id')->nullable();
            $table->unsignedInteger('job_entry_id');
            $table->unsignedInteger('customer_id');
            $table->timestamps();

            $table->foreign('job_entry_id')->references('id')->on('job_entries')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('balance_sheet_amount_1_id')->references('id')->on('balance_sheet_amount_1');
            $table->foreign('balance_sheet_amount_2_id')->references('id')->on('balance_sheet_amount_2');
            $table->foreign('balance_sheet_variation_id')->references('id')->on('balance_sheet_variation');
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

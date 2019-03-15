<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePnlExcelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pnl_excel', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pnl_debit_id')->nullable();
            $table->unsignedInteger('pnl_credit_id')->nullable();
            $table->unsignedInteger('pnl_variation_id')->nullable();
            $table->unsignedInteger('job_entry_id');
            $table->unsignedInteger('member_id');
            $table->timestamps();

            $table->foreign('job_entry_id')->references('id')->on('job_entries')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('pnl_debit_id')->references('id')->on('pnl_debit');
            $table->foreign('pnl_credit_id')->references('id')->on('pnl_credit');
            $table->foreign('pnl_variation_id')->references('id')->on('pnl_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pnl_excel');
    }
}

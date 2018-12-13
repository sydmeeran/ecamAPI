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
            $table->integer('var1');
            $table->integer('var2');
            $table->integer('var3');
            $table->unsignedInteger('job_entry_id');
            $table->timestamps();

            $table->foreign('job_entry_id')->references('id')->on('job_entries')->onDelete('cascade');
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

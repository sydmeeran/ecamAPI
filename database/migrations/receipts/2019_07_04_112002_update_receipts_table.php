<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('receipt_id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('sponsor_donate_id')->nullable();
            $table->string('type');
            $table->string('bank')->nullable();
            $table->date('bank_date')->nullable();
            $table->date('cash_date')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('sponsor_donate_id')->references('id')->on('sponsor_and_donate')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

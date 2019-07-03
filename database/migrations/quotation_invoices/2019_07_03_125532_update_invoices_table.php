<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('invoice_remarks');
        Schema::dropIfExists('accounting_service');
        Schema::dropIfExists('taxation');
        Schema::dropIfExists('consulting');
        Schema::dropIfExists('auditing');
        Schema::dropIfExists('receipts');

        Schema::dropIfExists('invoices');

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('business_id');
            $table->string('payment_type');
            $table->string('payment_date');
            $table->integer('member_fee');
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('business_id')->references('id')->on('businesses');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quotation_id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('business_id');
            $table->integer('sub_total');
            $table->integer('discount');
            $table->integer('tax')->default(0);
            $table->float('total');
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}

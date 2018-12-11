<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('company_id');
            $table->string('company_name');
            $table->string('owner_name');
            $table->string('nrc_no');
            $table->string('nrc_photo');
            $table->string('phone_no');
            $table->string('email');
            $table->string('contact_name');
            $table->string('contact_position');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->string('otp', 10);
            $table->string('company_dica_link')->nullable();
            $table->string('company_link')->nullable();
            $table->boolean('is_use')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_suspend')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}

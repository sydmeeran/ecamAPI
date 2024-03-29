<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 10);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('company_type');
            $table->string('excel_type');
            $table->string('excel_file');
            $table->unsignedInteger('member_id');
            $table->timestamps();

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
        Schema::dropIfExists('job_entries');
    }
}

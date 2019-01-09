<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePnlVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pnl_variation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('income')->nullable();
            $table->integer('total_income')->nullable();
            $table->integer('cost_of_sales')->nullable();
            $table->integer('purchases')->nullable();
            $table->integer('direct_material_cost')->nullable();
            $table->integer('direct_labour_cost')->nullable();
            $table->integer('direct_expenses')->nullable();
            $table->integer('total_cost_of_sales')->nullable();
            $table->integer('gross_profit')->nullable();
            $table->integer('expense')->nullable();
            $table->integer('admin_expense')->nullable();
            $table->integer('staff_salaries')->nullable();
            $table->integer('staff_income_tax')->nullable();
            $table->integer('employment_expenses')->nullable();
            $table->integer('meal_allowance_staff')->nullable();
            $table->integer('phone_top_up_staff')->nullable();
            $table->integer('admin_uniforms_staff')->nullable();
            $table->integer('director_allowance')->nullable();
            $table->integer('admin_printing_stationery')->nullable();
            $table->integer('admin_office_supplies')->nullable();
            $table->integer('refresh_entertainment')->nullable();
            $table->integer('upkeep_cost')->nullable();
            $table->integer('donation')->nullable();
            $table->integer('total_admin_expenses')->nullable();
            $table->integer('selling_distribution_expenses')->nullable();
            $table->integer('advertising_promotion_fees')->nullable();
            $table->integer('selling_printing_stationery')->nullable();
            $table->integer('repair_maintenance')->nullable();
            $table->integer('selling_office_supplies')->nullable();
            $table->integer('selling_uniforms_staff')->nullable();
            $table->integer('total_selling_distribution_expenses')->nullable();
            $table->integer('total_expenses')->nullable();
            $table->integer('operating_profit')->nullable();
            $table->integer('other_income')->nullable();
            $table->integer('total_other_income')->nullable();
            $table->integer('other_expenses')->nullable();
            $table->integer('total_other_expenses')->nullable();
            $table->integer('net_profit_loss')->nullable();
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
        Schema::dropIfExists('pnl_variation');
    }
}

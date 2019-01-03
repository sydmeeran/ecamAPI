<?php

namespace App\Models\PnlExcel;

use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    protected $table = 'pnl_debit';

    protected $fillable = [
        'income', 'total_income', 'cost_of_sales', 'purchases', 'direct_material_cost',
        'direct_labour_cost', 'direct_expenses', 'total_cost_of_sales', 'gross_profit',
        'expense', 'admin_expense', 'staff_salaries', 'staff_income_tax', 'employment_expenses',
        'meal_allowance_staff', 'phone_top_up_staff', 'admin_uniforms_staff', 'director_allowance',
        'admin_printing_stationery', 'admin_office_supplies', 'refresh_entertainment', 'upkeep_cost',
        'donation', 'total_admin_expenses', 'selling_distribution_expenses', 'advertising_promotion_fees',
        'selling_printing_stationery', 'repair_maintenance', 'selling_office_supplies', 'selling_uniforms_staff',
        'total_selling_distribution_expenses', 'total_expenses', 'operating_profit',
        'other_income', 'total_other_income', 'other_expenses', 'total_other_expenses',
        'net_profit_loss'
    ];

    public function pnl_excel(){
        return $this->hasOne('pnl_excel');
    }
}

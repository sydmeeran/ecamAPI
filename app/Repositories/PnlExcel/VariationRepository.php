<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 1/2/19
 * Time: 3:50 PM
 */

namespace App\Repositories\PnlExcel;


use App\Variation;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VariationRepository extends BaseRepository
{
    public function model(){
        return Variation::query();
    }

    public function validation($data, $excel_file){
        $validator = Validator::make($data, [
            'income' => 'int|nullable',
            'total_income' => 'int|nullable',
            'cost_of_sales' => 'int|nullable',
            'purchases' => 'int|nullable',
            'direct_material_cost' => 'int|nullable',
            'direct_labour_cost' => 'int|nullable',
            'direct_expenses' => 'int|nullable',
            'total_cost_of_sales' => 'int|nullable',
            'gross_profit' => 'int|nullable',
            'expense' => 'int|nullable',
            'admin_expense' => 'int|nullable',
            'staff_salaries' => 'int|nullable',
            'staff_income_tax' => 'int|nullable',
            'employment_expenses' => 'int|nullable',
            'meal_allowance_staff' => 'int|nullable',
            'phone_top_up_staff' => 'int|nullable',
            'admin_uniforms_staff' => 'int|nullable',
            'director_allowance' => 'int|nullable',
            'admin_printing_stationery' => 'int|nullable',
            'admin_office_supplies' => 'int|nullable',
            'refresh_entertainment' => 'int|nullable',
            'upkeep_cost' => 'int|nullable',
            'donation' => 'int|nullable',
            'total_admin_expenses' => 'int|nullable',
            'selling_distribution_expenses' => 'int|nullable',
            'advertising_promotion_fees' => 'int|nullable',
            'selling_printing_stationery' => 'int|nullable',
            'repair_maintenance' => 'int|nullable',
            'selling_office_supplies' => 'int|nullable',
            'selling_uniforms_staff' => 'int|nullable',
            'total_selling_distribution_expenses' => 'int|nullable',
            'total_expenses' => 'int|nullable',
            'operating_profit' => 'int|nullable',
            'other_income' => 'int|nullable',
            'total_other_income' => 'int|nullable',
            'other_expenses' => 'int|nullable',
            'total_other_expenses' => 'int|nullable',
            'net_profit_loss' => 'int|nullable',
        ]);

        if($validator->fails()){
            if(file_exists($excel_file)){
                unlink($excel_file);
            }
            throw new ValidationException($validator);
        }
    }

    public function setData($excel_file){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        /** Load $inputFileName to a Spreadsheet Object  **/
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excel_file)->getActiveSheet();

        $income = $spreadsheet->getCell('E3')->getValue();
        $total_income = $spreadsheet->getCell('E5')->getValue();
        $cost_of_sales = $spreadsheet->getCell('E7')->getValue();
        $purchases = $spreadsheet->getCell('E8')->getValue();
        $direct_material_cost = $spreadsheet->getCell('E9')->getValue();
        $direct_labour_cost = $spreadsheet->getCell('E10')->getValue();
        $direct_expenses = $spreadsheet->getCell('E11')->getValue();
        $total_cost_of_sales = $spreadsheet->getCell('E12')->getValue();
        $gross_profit = $spreadsheet->getCell('E14')->getValue();
        $expense = $spreadsheet->getCell('E16')->getValue();
        $admin_expense = $spreadsheet->getCell('E17')->getValue();
        $staff_salaries = $spreadsheet->getCell('E18')->getValue();
        $staff_income_tax = $spreadsheet->getCell('E19')->getValue();
        $employment_expenses = $spreadsheet->getCell('E20')->getValue();
        $meal_allowance_staff = $spreadsheet->getCell('E21')->getValue();
        $phone_top_up_staff = $spreadsheet->getCell('E22')->getValue();
        $admin_uniforms_staff = $spreadsheet->getCell('E23')->getValue();
        $director_allowance = $spreadsheet->getCell('E24')->getValue();
        $admin_printing_stationery = $spreadsheet->getCell('E25')->getValue();
        $admin_office_supplies = $spreadsheet->getCell('E26')->getValue();
        $refresh_entertainment = $spreadsheet->getCell('E27')->getValue();
        $upkeep_cost = $spreadsheet->getCell('E28')->getValue();
        $donation = $spreadsheet->getCell('E29')->getValue();
        $total_admin_expenses = $spreadsheet->getCell('E30')->getValue();
        $selling_distribution_expenses = $spreadsheet->getCell('E31')->getValue();
        $advertising_promotion_fees = $spreadsheet->getCell('E32')->getValue();
        $selling_printing_stationery = $spreadsheet->getCell('E33')->getValue();
        $repair_maintenance = $spreadsheet->getCell('E34')->getValue();
        $selling_office_supplies = $spreadsheet->getCell('E35')->getValue();
        $selling_uniforms_staff = $spreadsheet->getCell('E36')->getValue();
        $total_selling_distribution_expenses = $spreadsheet->getCell('E37')->getValue();
        $total_expenses = $spreadsheet->getCell('E38')->getValue();
        $operating_profit = $spreadsheet->getCell('E39')->getValue();
        $other_income = $spreadsheet->getCell('E40')->getValue();
        $total_other_income = $spreadsheet->getCell('E41')->getValue();
        $other_expenses = $spreadsheet->getCell('E43')->getValue();
        $total_other_expenses = $spreadsheet->getCell('E44')->getValue();
        $net_profit_loss = $spreadsheet->getCell('E46')->getValue();

        $data = [
            'income' => $income,
            'total_income' => $total_income,
            'cost_of_sales' => $cost_of_sales,
            'purchases' => $purchases,
            'direct_material_cost' => $direct_material_cost,
            'direct_labour_cost' => $direct_labour_cost,
            'direct_expenses' => $direct_expenses,
            'total_cost_of_sales' => $total_cost_of_sales,
            'gross_profit' => $gross_profit,
            'expense' => $expense,
            'admin_expense' => $admin_expense,
            'staff_salaries' => $staff_salaries,
            'staff_income_tax' => $staff_income_tax,
            'employment_expenses' => $employment_expenses,
            'meal_allowance_staff' => $meal_allowance_staff,
            'phone_top_up_staff' => $phone_top_up_staff,
            'admin_uniforms_staff' => $admin_uniforms_staff,
            'director_allowance' => $director_allowance,
            'admin_printing_stationery' => $admin_printing_stationery,
            'admin_office_supplies' => $admin_office_supplies,
            'refresh_entertainment' => $refresh_entertainment,
            'upkeep_cost' => $upkeep_cost,
            'donation' => $donation,
            'total_admin_expenses' => $total_admin_expenses,
            'selling_distribution_expenses' => $selling_distribution_expenses,
            'advertising_promotion_fees' => $advertising_promotion_fees,
            'selling_printing_stationery' => $selling_printing_stationery,
            'repair_maintenance' => $repair_maintenance,
            'selling_office_supplies' => $selling_office_supplies,
            'selling_uniforms_staff' => $selling_uniforms_staff,
            'total_selling_distribution_expenses' => $total_selling_distribution_expenses,
            'total_expenses' => $total_expenses,
            'operating_profit' => $operating_profit,
            'other_income' => $other_income,
            'total_other_income' => $total_other_income,
            'other_expenses' => $other_expenses,
            'total_other_expenses' => $total_other_expenses,
            'net_profit_loss' => $net_profit_loss,
        ];
        return $data;
    }

    public function store($excel_file){
        $variation_data = $this->setData($excel_file);

        $this->validation($variation_data, $excel_file);

        $variation = $this->model()->create($variation_data);
        return $variation->id;
    }
}
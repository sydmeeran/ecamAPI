<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/13/18
 * Time: 2:47 PM
 */

namespace App\Repositories;


use App\BalanceSheetExcel;
use Illuminate\Support\Facades\Validator;

class BalanceSheetExcelRepository extends BaseRepository
{
    protected $amount_1, $amount_2, $variation, $pnl_excel;

    public function __construct()
    {
        $this->amount_1 = DataRepo::balance_sheet_amount_1();
        $this->amount_2 = DataRepo::balance_sheet_amount_2();
        $this->variation = DataRepo::balance_sheet_variation();

    }
    
    public function model(){
        return BalanceSheetExcel::query();
    }

    public function store($excel_file, $job_entry_id, $customer_id){
        $amount_1_id = $this->amount_1->store($excel_file);

        $amount_2_id = $this->amount_2->store($excel_file);

        $variation_id = $this->variation->store($excel_file);

        $this->model()->create([
            'balance_sheet_amount_1_id' => $amount_1_id,
            'balance_sheet_amount_2_id' => $amount_2_id,
            'balance_sheet_variation_id' => $variation_id,
            'job_entry_id' => $job_entry_id,
            'customer_id' => $customer_id,
        ]);
        return 'success';
    }

    public function update($excel_file, $job_entry_id, $customer_id){
        $this->amount_1->validation($this->amount_1->setData($excel_file), $excel_file);
        $this->amount_2->validation($this->amount_2->setData($excel_file), $excel_file);
        $this->variation->validation($this->variation->setData($excel_file), $excel_file);

        $this->pnl_excel = DataRepo::pnl_excel();
        $pnl_excel = $this->pnl_excel->model()->where('job_entry_id', $job_entry_id)->get();
        if(!$pnl_excel->isEmpty()){
            $this->pnl_excel->destroy($pnl_excel);
        }

        $balance_sheet = $this->model()->where('job_entry_id', $job_entry_id)->get();
        if(!$balance_sheet->isEmpty()){
            $this->delete($balance_sheet->toArray()[0]['id']);
        }

        $amount_1_id = $this->amount_1->store($excel_file);
        $amount_2_id = $this->amount_2->store($excel_file);
        $variation_id = $this->variation->store($excel_file);

        $this->model()->create([
            'balance_sheet_amount_1_id' => $amount_1_id,
            'balance_sheet_amount_2_id' => $amount_2_id,
            'balance_sheet_variation_id' => $variation_id,
            'job_entry_id' => $job_entry_id,
            'customer_id' => $customer_id,
        ]);
        return 'success';
    }

    public function destroy($balance_sheet){
        $balance_sheet_data = $balance_sheet->toArray()[0];
        $this->delete($balance_sheet_data['id']);
        $this->amount_1->delete($balance_sheet_data['balance_sheet_amount_1_id']);
        $this->amount_2->delete($balance_sheet_data['balance_sheet_amount_2_id']);
        $this->variation->delete($balance_sheet_data['balance_sheet_variation_id']);
    }
}
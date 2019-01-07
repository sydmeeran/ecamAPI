<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/13/18
 * Time: 2:47 PM
 */

namespace App\Repositories;

use App\PnlExcel;

class PnlExcelRepository extends BaseRepository
{
    protected $debit, $credit, $variation, $balance_sheet_excel;

    public function __construct()
    {
        $this->debit = DataRepo::pnl_debit();
        $this->credit = DataRepo::pnl_credit();
        $this->variation = DataRepo::pnl_variation();

    }

    public function model(){
        return PnlExcel::query();
    }

    public function store($excel_file, $job_entry_id, $customer_id){
        $debit_id = $this->debit->store($excel_file);

        $credit_id = $this->credit->store($excel_file);

        $variation_id = $this->variation->store($excel_file);

        $this->model()->create([
            'pnl_debit_id' => $debit_id,
            'pnl_credit_id' => $credit_id,
            'pnl_variation_id' => $variation_id,
            'job_entry_id' => $job_entry_id,
            'customer_id' => $customer_id,
        ]);
        return 'success';
    }

    public function update($excel_file, $job_entry_id, $customer_id){
        $this->debit->validation($this->debit->setData($excel_file), $excel_file);
        $this->credit->validation($this->credit->setData($excel_file), $excel_file);
        $this->variation->validation($this->variation->setData($excel_file), $excel_file);

        $pnl_excel = $this->model()->where('job_entry_id', $job_entry_id)->get();
        if(!$pnl_excel->isEmpty()){
            $this->delete($pnl_excel->toArray()[0]['id']);
        }
        $this->balance_sheet_excel = DataRepo::balance_sheet_excel();
        $balance_sheet = $this->balance_sheet_excel->model()->where('job_entry_id', $job_entry_id)->get();
        if(!$balance_sheet->isEmpty()){
            $this->balance_sheet_excel->destroy($balance_sheet);
        }

        $debit_id = $this->debit->store($excel_file);
        $credit_id = $this->credit->store($excel_file);
        $variation_id = $this->variation->store($excel_file);

        $this->model()->create([
            'pnl_debit_id' => $debit_id,
            'pnl_credit_id' => $credit_id,
            'pnl_variation_id' => $variation_id,
            'job_entry_id' => $job_entry_id,
            'customer_id' => $customer_id,
        ]);
        return 'success';
    }

    public function destroy($pnl){
        $pnl_data = $pnl->toArray()[0];
        $this->delete($pnl_data['id']);
        $this->debit->delete($pnl_data['pnl_debit_id']);
        $this->credit->delete($pnl_data['pnl_credit_id']);
        $this->variation->delete($pnl_data['pnl_variation_id']);
    }

}
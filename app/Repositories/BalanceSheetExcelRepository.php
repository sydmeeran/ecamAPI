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
use Illuminate\Validation\ValidationException;

class BalanceSheetExcelRepository extends BaseRepository
{
    protected $pnl_excel;

    public function model(){
        return BalanceSheetExcel::query();
    }

    public function validation($data, $excel_file)
    {
        $validator = Validator::make($data, [
            "non_current_assets" => 'string|nullable',
            "total_non_current_assets" => 'string|nullable',
            "current_assets" => 'string|nullable',

            "total_current_assets" => 'string|nullable',
            "total_assets" => 'string|nullable',

            "long_term_loan" => 'string|nullable',
            "non_current_deferred_income" => 'string|nullable',
            "deferred_tax" => 'string|nullable',
            "total_non_current_liabilities" => 'string|nullable',

            "current_liabilities" => 'string|nullable',
            "trade_creditors" => 'string|nullable',
            "current_deferred_income" => 'string|nullable',
            "salary_payable" => 'string|nullable',
            "internet_bill" => 'string|nullable',
            "social_security_fees" => 'string|nullable',
            "electricity_charges" => 'string|nullable',
            "staff_fund" => 'string|nullable',
            "bod_salaries" => 'string|nullable',
            "consultant_salaries" => 'string|nullable',
            "payable_stamp_duty" => 'string|nullable',
            "payable_bonus" => 'string|nullable',
            "bod_consultant_salaries_tax" => 'string|nullable',
            "advance_2_and_5_percent_tax" => 'string|nullable',
            "2_percent_tax" => 'string|nullable',
            "5_percent_commercial_tax" => 'string|nullable',
            "total_current_liabilities" => 'string|nullable',
            "total_liabilities" => 'string|nullable',
            "net_assets" => 'string|nullable',
            "equity" => 'string|nullable',
            "owner_shareholders_equity" => 'string|nullable',
            "capital" => 'string|nullable',

            "total_owner_shareholders_equity" => 'string|nullable',
            "retained_earnings" => 'string|nullable',
            "profit_loss_for_the_year" => 'string|nullable',
            "profit_divided" => 'string|nullable',
            "total_equity" => 'string|nullable',
        ]);

        if ($validator->fails()) {
            if (file_exists($excel_file)) {
                unlink($excel_file);
            }
            throw new ValidationException($validator);
        }
    }
    
    public function setValue($spreadsheet, $index, $with = null){
        $data = [
            'amount_1' => $spreadsheet->getCell('C'.$index)->getValue(),
            'amount_2' => $spreadsheet->getCell('D'.$index)->getValue(),
            'variation' => $spreadsheet->getCell('E'.$index)->getValue(),
        ];
        if($with == 'title'){
            $data['title'] = $spreadsheet->getCell('B'.$index)->getValue();
        }
        return $data;
    }

    public function setData($excel_file)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        /** Load $inputFileName to a Spreadsheet Object  **/
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excel_file)->getActiveSheet();

        $i = 5;
        while($spreadsheet->getCell('B'.$i)->getValue() != "Total Non Current Assets"){
            $non_current_assets[] = $this->setValue($spreadsheet, $i, 'title');
            $i++;
        }

        $total_non_current_assets[] = $this->setValue($spreadsheet, $i);

        $i = $i + 3;
        while($spreadsheet->getCell('B'.$i)->getValue() != "Total Current Assets"){
            $current_assets[] = $this->setValue($spreadsheet, $i, 'title');
            $i++;
        }

        $total_current_assets[] = $this->setValue($spreadsheet, $i);
        $i++;

        $total_assets[] = $this->setValue($spreadsheet, $i);

        $i = $i + 3;
        $long_term_loan[] = $this->setValue($spreadsheet, $i);
        $i++;
        $non_current_deferred_income[] = $this->setValue($spreadsheet, $i);
        $i++;
        $deferred_tax[] = $this->setValue($spreadsheet, $i);
        $i++;
        $total_non_current_liabilities[] = $this->setValue($spreadsheet, $i);

        $i = $i + 4;
        $trade_creditors[] = $this->setValue($spreadsheet, $i);
        $i++;
        $current_deferred_income[] = $this->setValue($spreadsheet, $i);
        $i++;
        $salary_payable[] = $this->setValue($spreadsheet, $i);
        $i++;
        $internet_bill[] = $this->setValue($spreadsheet, $i);
        $i++;
        $social_security_fees[] = $this->setValue($spreadsheet, $i);
        $i++;
        $electricity_charges[] = $this->setValue($spreadsheet, $i);
        $i++;
        $staff_fund[] = $this->setValue($spreadsheet, $i);
        $i++;
        $bod_salaries[] = $this->setValue($spreadsheet, $i);
        $i++;
        $consultant_salaries[] = $this->setValue($spreadsheet, $i);
        $i++;
        $payable_stamp_duty[] = $this->setValue($spreadsheet, $i);
        $i++;
        $payable_bonus[] = $this->setValue($spreadsheet, $i);
        $i++;
        $bod_consultant_salaries_tax[] = $this->setValue($spreadsheet, $i);
        $i++;
        $advance_2_and_5_percent_tax[] = $this->setValue($spreadsheet, $i);
        $i++;
        $two_percent_tax[] = $this->setValue($spreadsheet, $i);
        $i++;
        $five_percent_commercial_tax[] = $this->setValue($spreadsheet, $i);
        $i++;
        $total_current_liabilities[] = $this->setValue($spreadsheet, $i);
        $i++;
        $total_liabilities[] = $this->setValue($spreadsheet, $i);
        $i++;
        $net_assets[] = $this->setValue($spreadsheet, $i);
        $i++;
        $equity[] = $this->setValue($spreadsheet, $i);
        $i++;
        $owner_shareholders_equity[] = $this->setValue($spreadsheet, $i);
        $i++;
        $capital[] = $this->setValue($spreadsheet, $i);

        $i = $i + 2;
        $total_owner_shareholders_equity[] = $this->setValue($spreadsheet, $i);
        $i++;
        $retained_earnings[] = $this->setValue($spreadsheet, $i);
        $i++;
        $profit_loss_for_the_year[] = $this->setValue($spreadsheet, $i);
        $i++;
        $profit_divided[] = $this->setValue($spreadsheet, $i);
        $i++;
        $total_equity[] = $this->setValue($spreadsheet, $i);

        $data = [
            'non_current_assets' => json_encode($non_current_assets),
            'total_non_current_assets' => json_encode($total_non_current_assets),

            'current_assets' => json_encode($current_assets),
            'total_current_assets' => json_encode($total_current_assets),
            'total_assets' => json_encode($total_assets),

            'long_term_loan' => json_encode($long_term_loan),
            'non_current_deferred_income' => json_encode($non_current_deferred_income),
            'deferred_tax' => json_encode($deferred_tax),
            'total_non_current_liabilities' => json_encode($total_non_current_liabilities),

            'trade_creditors' => json_encode($trade_creditors),
            'current_deferred_income' => json_encode($current_deferred_income),
            'salary_payable' => json_encode($salary_payable),
            'internet_bill' => json_encode($internet_bill),
            'social_security_fees' => json_encode($social_security_fees),
            'electricity_charges' => json_encode($electricity_charges),
            'staff_fund' => json_encode($staff_fund),
            'bod_salaries' => json_encode($bod_salaries),
            'consultant_salaries' => json_encode($consultant_salaries),
            'payable_stamp_duty' => json_encode($payable_stamp_duty),
            'payable_bonus' => json_encode($payable_bonus),
            'bod_consultant_salaries_tax' => json_encode($bod_consultant_salaries_tax),
            'advance_2_and_5_percent_tax' => json_encode($advance_2_and_5_percent_tax),
            '2_percent_tax' => json_encode($two_percent_tax),
            '5_percent_commercial_tax' => json_encode($five_percent_commercial_tax),
            'total_current_liabilities' => json_encode($total_current_liabilities),
            'total_liabilities' => json_encode($total_liabilities),
            'net_assets' => json_encode($net_assets),
            'equity' => json_encode($equity),
            'owner_shareholders_equity' => json_encode($owner_shareholders_equity),
            'capital' => json_encode($capital),

            'total_owner_shareholders_equity' => json_encode($total_owner_shareholders_equity),
            'retained_earnings' => json_encode($retained_earnings),
            'profit_loss_for_the_year' => json_encode($profit_loss_for_the_year),
            'profit_divided' => json_encode($profit_divided),
            'total_equity' => json_encode($total_equity),
        ];
        return $data;
    }

    public function store($excel_file, $job_entry_id, $customer_id){

        $data = $this->setData($excel_file);

        $this->validation($data, $excel_file);

        $data['job_entry_id'] = $job_entry_id;
        $data['customer_id'] = $customer_id;

        $this->model()->create($data);

        return 'success';
    }

    public function update($excel_file, $job_entry_id, $customer_id){
        $this->pnl_excel = DataRepo::pnl_excel();
        $pnl_excel = $this->pnl_excel->model()->where('job_entry_id', $job_entry_id)->get();
        if(!$pnl_excel->isEmpty()){
            $this->pnl_excel->destroy($pnl_excel);
            $this->store($excel_file, $job_entry_id, $customer_id);
        } else {
            $data = $this->setData($excel_file);
            $this->validation($data, $excel_file);
            $balance_sheet = $this->model()->where('job_entry_id', $job_entry_id)->get();
            if(!$balance_sheet->isEmpty()){
                $this->model()->where('id', $balance_sheet->toArray()[0]['id'])->update($data);
            }
        }

        return 'success';
    }

//    public function destroy($balance_sheet){
//        $balance_sheet_data = $balance_sheet->toArray()[0];
//        $this->delete($balance_sheet_data['id']);
//        $this->amount_1->delete($balance_sheet_data['balance_sheet_amount_1_id']);
//        $this->amount_2->delete($balance_sheet_data['balance_sheet_amount_2_id']);
//        $this->variation->delete($balance_sheet_data['balance_sheet_variation_id']);
//    }
}
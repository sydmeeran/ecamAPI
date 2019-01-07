<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 1/2/19
 * Time: 2:00 PM
 */

namespace App\Repositories\BalanceSheetExcel;

use App\Models\BalanceSheetExcel\Variation;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use JsonSchema\Exception\ValidationException;

class VariationRepository extends BaseRepository
{
    public function model()
    {
        return Variation::query();
    }

    public function validation($data, $excel_file)
    {
        $validator = Validator::make($data, [
            "non_current_assets" => 'string|nullable',
            "total_non_current_assets" => 'int|nullable',
            "current_assets" => 'string|nullable',

            "total_current_assets" => 'int|nullable',
            "total_assets" => 'int|nullable',

            "long_term_loan" => 'int|nullable',
            "non_current_deferred_income" => 'int|nullable',
            "deferred_tax" => 'int|nullable',
            "total_non_current_liabilities" => 'int|nullable',

            "current_liabilities" => 'string|nullable',
            "trade_creditors" => 'int|nullable',
            "current_deferred_income" => 'int|nullable',
            "salary_payable" => 'int|nullable',
            "internet_bill" => 'int|nullable',
            "social_security_fees" => 'int|nullable',
            "electricity_charges" => 'int|nullable',
            "staff_fund" => 'int|nullable',
            "bod_salaries" => 'int|nullable',
            "consultant_salaries" => 'int|nullable',
            "payable_stamp_duty" => 'int|nullable',
            "payable_bonus" => 'int|nullable',
            "bod_consultant_salaries_tax" => 'int|nullable',
            "advance_2_and_5_percent_tax" => 'int|nullable',
            "2_percent_tax" => 'int|nullable',
            "5_percent_commercial_tax" => 'int|nullable',
            "total_current_liabilities" => 'int|nullable',
            "total_liabilities" => 'int|nullable',
            "net_assets" => 'int|nullable',
            "equity" => 'int|nullable',
            "owner_shareholders_equity" => 'int|nullable',
            "capital" => 'int|nullable',

            "total_owner_shareholders_equity" => 'int|nullable',
            "retained_earnings" => 'int|nullable',
            "profit_loss_for_the_year" => 'int|nullable',
            "profit_divided" => 'int|nullable',
            "total_equity" => 'int|nullable',
        ]);

        if ($validator->fails()) {
            if (file_exists($excel_file)) {
                unlink($excel_file);
            }
            throw new ValidationException($validator);
        }
    }

    public function setData($excel_file)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        /** Load $inputFileName to a Spreadsheet Object  **/
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excel_file)->getActiveSheet();

        $i = 5;
        while($spreadsheet->getCell('B'.$i)->getValue() != "Total Non Current Assets"){
            $non_current_assets[] = [
                'title' => $spreadsheet->getCell('B'.$i)->getValue(),
                'value' => $spreadsheet->getCell('E'.$i)->getValue(),
            ];
            $i++;
        }

        $total_non_current_assets = $spreadsheet->getCell('C15')->getValue();

        $i = $i + 3;
        while($spreadsheet->getCell('B'.$i)->getValue() != "Total Current Assets"){
            $current_assets[] = [
                'title' => $spreadsheet->getCell('B'.$i)->getValue(),
                'value' => $spreadsheet->getCell('E'.$i)->getValue(),
            ];
            $i++;
        }

        $total_current_assets = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $total_assets = $spreadsheet->getCell('E'.$i)->getValue();

        $i = $i + 3;
        $long_term_loan = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $non_current_deferred_income = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $deferred_tax = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $total_non_current_liabilities = $spreadsheet->getCell('E'.$i)->getValue();

        $i = $i + 4;
        $trade_creditors = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $current_deferred_income = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $salary_payable = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $internet_bill = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $social_security_fees = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $electricity_charges = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $staff_fund = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $bod_salaries = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $consultant_salaries = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $payable_stamp_duty = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $payable_bonus = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $bod_consultant_salaries_tax = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $advance_2_and_5_percent_tax = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $two_percent_tax = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $five_percent_commercial_tax = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $total_current_liabilities = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $total_liabilities = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $net_assets = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $equity = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $owner_shareholders_equity = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $capital = $spreadsheet->getCell('E'.$i)->getValue();

        $i = $i + 2;
        $total_owner_shareholders_equity = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $retained_earnings = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $profit_loss_for_the_year = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $profit_divided = $spreadsheet->getCell('E'.$i)->getValue();$i++;
        $total_equity = $spreadsheet->getCell('E'.$i)->getValue();

        $data = [
            'non_current_assets' => json_encode($non_current_assets),
            'total_non_current_assets' => $total_non_current_assets,

            'current_assets' => json_encode($current_assets),
            'total_current_assets' => $total_current_assets,
            'total_assets' => $total_assets,

            'long_term_loan' => $long_term_loan,
            'non_current_deferred_income' => $non_current_deferred_income,
            'deferred_tax' => $deferred_tax,
            'total_non_current_liabilities' => $total_non_current_liabilities,

            'trade_creditors' => $trade_creditors,
            'current_deferred_income' => $current_deferred_income,
            'salary_payable' => $salary_payable,
            'internet_bill' => $internet_bill,
            'social_security_fees' => $social_security_fees,
            'electricity_charges' => $electricity_charges,
            'staff_fund' => $staff_fund,
            'bod_salaries' => $bod_salaries,
            'consultant_salaries' => $consultant_salaries,
            'payable_stamp_duty' => $payable_stamp_duty,
            'payable_bonus' => $payable_bonus,
            'bod_consultant_salaries_tax' => $bod_consultant_salaries_tax,
            'advance_2_and_5_percent_tax' => $advance_2_and_5_percent_tax,
            '2_percent_tax' => $two_percent_tax,
            '5_percent_commercial_tax' => $five_percent_commercial_tax,
            'total_current_liabilities' => $total_current_liabilities,
            'total_liabilities' => $total_liabilities,
            'net_assets' => $net_assets,
            'equity' => $equity,
            'owner_shareholders_equity' => $owner_shareholders_equity,
            'capital' => $capital,

            'total_owner_shareholders_equity' => $total_owner_shareholders_equity,
            'retained_earnings' => $retained_earnings,
            'profit_loss_for_the_year' => $profit_loss_for_the_year,
            'profit_divided' => $profit_divided,
            'total_equity' => $total_equity,
        ];
        return $data;
    }

    public function store($excel_file)
    {
        $variation_data = $this->setData($excel_file);

        $this->validation($variation_data, $excel_file);

        $variation = $this->model()->create($variation_data);
        return $variation->id;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 1/2/19
 * Time: 2:00 PM
 */

namespace App\Repositories\BalanceSheetExcel;

use App\Models\BalanceSheetExcel\Amount1;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use JsonSchema\Exception\ValidationException;

class Amount1Repository extends BaseRepository
{
    public function model()
    {
        return Amount1::query();
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
//non_current_assets
//computer_a_c
//computer_accum_dep
//furniture_fixture
//furniture_fixtures_accum_dep
//printer
//printer_accum_dep
//cctv_a_c
//cctv_accum_dep
//finger_print
//finger_print_accum_dep
//total_non_current_assets
//current_assets
//inventory
//trade_debtors
//cash_in_hand
//petty_cash
//bank_account
//prepaid
//advance_commercial_tax
//adv_income_tax
//advance
//total_current_assets
//total_assets
//non_current_liabilities
//long_term_loan
//deferred_income
//deferred_tax
//total_non_current_liabilities
//current_liabilities
//trade_creditors
//deferred_income
//salary_payable
//internet_bill
//social_security_fees
//electricity_charges
//staff_fund
//bod_salaries
//consultant_salaries
//payable_stamp_duty
//payable_bonus
//bod_consultant_salaries_tax
//advance_2_and_5_percent_tax
//2_percent_tax
//5_percent_commercial_tax
//total_current_liabilities
//total_liabilities
//net_assets
//equity
//owner_shareholders_equity
//capital
//total_owner_shareholders_equity
//retained_earnings
//profit_loss_for_the_year
//profit_divided
//total_equity
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
                'value' => $spreadsheet->getCell('C'.$i)->getValue(),
            ];
            $i++;
        }

        $total_non_current_assets = $spreadsheet->getCell('C15')->getValue();

        $i = $i + 3;
        while($spreadsheet->getCell('B'.$i)->getValue() != "Total Current Assets"){
            $current_assets[] = [
                'title' => $spreadsheet->getCell('B'.$i)->getValue(),
                'value' => $spreadsheet->getCell('C'.$i)->getValue(),
            ];
            $i++;
        }

        $total_current_assets = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $total_assets = $spreadsheet->getCell('C'.$i)->getValue();

        $i = $i + 3;
        $long_term_loan = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $non_current_deferred_income = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $deferred_tax = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $total_non_current_liabilities = $spreadsheet->getCell('C'.$i)->getValue();

        $i = $i + 4;
        $trade_creditors = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $current_deferred_income = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $salary_payable = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $internet_bill = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $social_security_fees = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $electricity_charges = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $staff_fund = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $bod_salaries = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $consultant_salaries = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $payable_stamp_duty = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $payable_bonus = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $bod_consultant_salaries_tax = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $advance_2_and_5_percent_tax = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $two_percent_tax = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $five_percent_commercial_tax = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $total_current_liabilities = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $total_liabilities = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $net_assets = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $equity = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $owner_shareholders_equity = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $capital = $spreadsheet->getCell('C'.$i)->getValue();

        $i = $i + 2;
        $total_owner_shareholders_equity = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $retained_earnings = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $profit_loss_for_the_year = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $profit_divided = $spreadsheet->getCell('C'.$i)->getValue();$i++;
        $total_equity = $spreadsheet->getCell('C'.$i)->getValue();

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
        $amount_1_data = $this->setData($excel_file);

        $this->validation($amount_1_data, $excel_file);

        $amount_1 = $this->model()->create($amount_1_data);
        return $amount_1->id;
    }
}
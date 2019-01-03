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

    public function validation($data)
    {
        return Validator::make($data, [
            "non_current_assets" => 'int|nullable',
            "computer_a_c" => 'int|nullable',
            "computer_accum_dep" => 'int|nullable',
            "furniture_fixture" => 'int|nullable',
            "furniture_fixtures_accum_dep" => 'int|nullable',
            "printer" => 'int|nullable',
            "printer_accum_dep" => 'int|nullable',
            "cctv_a_c" => 'int|nullable',
            "cctv_accum_dep" => 'int|nullable',
            "finger_print" => 'int|nullable',
            "finger_print_accum_dep" => 'int|nullable',
            "total_non_current_assets" => 'int|nullable',
            "current_assets" => 'int|nullable',
            "inventory" => 'int|nullable',
            "trade_debtors" => 'int|nullable',
            "cash_in_hand" => 'int|nullable',
            "petty_cash " => 'int|nullable',
            "bank_account" => 'int|nullable',
            "prepaid" => 'int|nullable',
            "advance_commercial_tax" => 'int|nullable',
            "adv_income_tax" => 'int|nullable',
            "advance" => 'int|nullable',
            "total_current_assets" => 'int|nullable',
            "total_assets" => 'int|nullable',
            "non_current_liabilities" => 'int|nullable',
            "long_term_loan" => 'int|nullable',
            "non_current_deferred_income" => 'int|nullable',
            "deferred_tax" => 'int|nullable',
            "total_non_current_liabilities" => 'int|nullable',
            "current_liabilities" => 'int|nullable',
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
    }
//$non_current_assets
//$computer_a_c
//$computer_accum_dep
//$furniture_fixture
//$furniture_fixtures_accum_dep
//$printer
//$printer_accum_dep
//$cctv_a_c
//$cctv_accum_dep
//$finger_print
//$finger_print_accum_dep
//$total_non_current_assets
//$current_assets
//$inventory
//$trade_debtors
//$cash_in_hand
//$petty_cash
//$bank_account
//$prepaid
//$advance_commercial_tax
//$adv_income_tax
//$advance
//$total_current_assets
//$total_assets
//$non_current_liabilities
//$long_term_loan
//$deferred_income
//$deferred_tax
//$total_non_current_liabilities
//$current_liabilities
//$trade_creditors
//$deferred_income
//$salary_payable
//$internet_bill
//$social_security_fees
//$electricity_charges
//$staff_fund
//$bod_salaries
//$consultant_salaries
//$payable_stamp_duty
//$payable_bonus
//$bod_consultant_salaries_tax
//$advance_2_and_5_percent_tax
//$2_percent_tax
//$5_percent_commercial_tax
//$total_current_liabilities
//$total_liabilities
//$net_assets
//$equity
//$owner_shareholders_equity
//$capital
//$total_owner_shareholders_equity
//$retained_earnings
//$profit_loss_for_the_year
//$profit_divided
//$total_equity
    public function setData($excel_file)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        /** Load $inputFileName to a Spreadsheet Object  **/
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($excel_file)->getActiveSheet();

        $non_current_assets = $spreadsheet->getCell('C4')->getValue();
        $computer_a_c = $spreadsheet->getCell('C5')->getValue();
        $computer_accum_dep = $spreadsheet->getCell('C6')->getValue();
        $furniture_fixture = $spreadsheet->getCell('C7')->getValue();
        $furniture_fixtures_accum_dep = $spreadsheet->getCell('C8')->getValue();
        $printer = $spreadsheet->getCell('C9')->getValue();
        $printer_accum_dep = $spreadsheet->getCell('C10')->getValue();
        $cctv_a_c = $spreadsheet->getCell('C11')->getValue();
        $cctv_accum_dep = $spreadsheet->getCell('C12')->getValue();
        $finger_print = $spreadsheet->getCell('C13')->getValue();
        $finger_print_accum_dep = $spreadsheet->getCell('C14')->getValue();
        $total_non_current_assets = $spreadsheet->getCell('C15')->getValue();
        $current_assets = $spreadsheet->getCell('C16')->getValue();
        $inventory = $spreadsheet->getCell('C18')->getValue();
        $trade_debtors = $spreadsheet->getCell('C19')->getValue();
        $cash_in_hand = $spreadsheet->getCell('C20')->getValue();
        $petty_cash  = $spreadsheet->getCell('C21')->getValue();
        $bank_account = $spreadsheet->getCell('C22')->getValue();
        $prepaid = $spreadsheet->getCell('C23')->getValue();
        $advance_commercial_tax = $spreadsheet->getCell('C24')->getValue();
        $adv_income_tax = $spreadsheet->getCell('C25')->getValue();
        $advance = $spreadsheet->getCell('C26')->getValue();
        $total_current_assets = $spreadsheet->getCell('C27')->getValue();
        $total_assets = $spreadsheet->getCell('C28')->getValue();
        $non_current_liabilities = $spreadsheet->getCell('C30')->getValue();
        $long_term_loan = $spreadsheet->getCell('C31')->getValue();
        $non_current_deferred_income = $spreadsheet->getCell('C32')->getValue();
        $deferred_tax = $spreadsheet->getCell('C33')->getValue();
        $total_non_current_liabilities = $spreadsheet->getCell('C34')->getValue();
        $current_liabilities = $spreadsheet->getCell('C36')->getValue();
        $trade_creditors = $spreadsheet->getCell('C38')->getValue();
        $current_deferred_income = $spreadsheet->getCell('C39')->getValue();
        $salary_payable = $spreadsheet->getCell('C40')->getValue();
        $internet_bill = $spreadsheet->getCell('C41')->getValue();
        $social_security_fees = $spreadsheet->getCell('C42')->getValue();
        $electricity_charges = $spreadsheet->getCell('C43')->getValue();
        $staff_fund = $spreadsheet->getCell('C44')->getValue();
        $bod_salaries = $spreadsheet->getCell('C45')->getValue();
        $consultant_salaries = $spreadsheet->getCell('C46')->getValue();
        $payable_stamp_duty = $spreadsheet->getCell('C47')->getValue();
        $payable_bonus = $spreadsheet->getCell('C48')->getValue();
        $bod_consultant_salaries_tax = $spreadsheet->getCell('C49')->getValue();
        $advance_2_and_5_percent_tax = $spreadsheet->getCell('C50')->getValue();
        $two_percent_tax = $spreadsheet->getCell('C51')->getValue();
        $five_percent_commercial_tax = $spreadsheet->getCell('C52')->getValue();
        $total_current_liabilities = $spreadsheet->getCell('C53')->getValue();
        $total_liabilities = $spreadsheet->getCell('C54')->getValue();
        $net_assets = $spreadsheet->getCell('C55')->getValue();
        $equity = $spreadsheet->getCell('C56')->getValue();
        $owner_shareholders_equity = $spreadsheet->getCell('C57')->getValue();
        $capital = $spreadsheet->getCell('C58')->getValue();
        $total_owner_shareholders_equity = $spreadsheet->getCell('C60')->getValue();
        $retained_earnings = $spreadsheet->getCell('C61')->getValue();
        $profit_loss_for_the_year = $spreadsheet->getCell('C62')->getValue();
        $profit_divided = $spreadsheet->getCell('C63')->getValue();
        $total_equity = $spreadsheet->getCell('C64')->getValue();

        $data = [
            'non_current_assets' => $non_current_assets,
            'computer_a_c' => $computer_a_c,
            'computer_accum_dep' => $computer_accum_dep,
            'furniture_fixture' => $furniture_fixture,
            'furniture_fixtures_accum_dep' => $furniture_fixtures_accum_dep,
            'printer' => $printer,
            'printer_accum_dep' => $printer_accum_dep,
            'cctv_a_c' => $cctv_a_c,
            'cctv_accum_dep' => $cctv_accum_dep,
            'finger_print' => $finger_print,
            'finger_print_accum_dep' => $finger_print_accum_dep,
            'total_non_current_assets' => $total_non_current_assets,
            'current_assets' => $current_assets,
            'inventory' => $inventory,
            'trade_debtors' => $trade_debtors,
            'cash_in_hand' => $cash_in_hand,
            'petty_cash' => $petty_cash ,
            'bank_account' => $bank_account,
            'prepaid' => $prepaid,
            'advance_commercial_tax' => $advance_commercial_tax,
            'adv_income_tax' => $adv_income_tax,
            'advance' => $advance,
            'total_current_assets' => $total_current_assets,
            'total_assets' => $total_assets,
            'non_current_liabilities' => $non_current_liabilities,
            'long_term_loan' => $long_term_loan,
            'non_current_deferred_income' => $non_current_deferred_income,
            'deferred_tax' => $deferred_tax,
            'total_non_current_liabilities' => $total_non_current_liabilities,
            'current_liabilities' => $current_liabilities,
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

        $validator = $this->validation($amount_1_data);
        if ($validator->fails()) {
            if (file_exists($excel_file)) {
                unlink($excel_file);
            }
            throw new ValidationException($validator);
        }

        $amount_1 = $this->model()->create($amount_1_data);
        return $amount_1->id;
    }
}
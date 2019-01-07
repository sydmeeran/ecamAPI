<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 1/2/19
 * Time: 2:00 PM
 */

namespace App\Repositories\BalanceSheetExcel;

use App\Models\BalanceSheetExcel\Amount2;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use JsonSchema\Exception\ValidationException;

class Amount2Repository extends BaseRepository
{
    public function model()
    {
        return Amount2::query();
    }

    public function validation($data, $excel_file)
    {
        $validator = Validator::make($data, [
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

        $non_current_assets = $spreadsheet->getCell('D4')->getValue();
        $computer_a_c = $spreadsheet->getCell('D5')->getValue();
        $computer_accum_dep = $spreadsheet->getCell('D6')->getValue();
        $furniture_fixture = $spreadsheet->getCell('D7')->getValue();
        $furniture_fixtures_accum_dep = $spreadsheet->getCell('D8')->getValue();
        $printer = $spreadsheet->getCell('D9')->getValue();
        $printer_accum_dep = $spreadsheet->getCell('D10')->getValue();
        $cctv_a_c = $spreadsheet->getCell('D11')->getValue();
        $cctv_accum_dep = $spreadsheet->getCell('D12')->getValue();
        $finger_print = $spreadsheet->getCell('D13')->getValue();
        $finger_print_accum_dep = $spreadsheet->getCell('D14')->getValue();
        $total_non_current_assets = $spreadsheet->getCell('D15')->getValue();
        $current_assets = $spreadsheet->getCell('D16')->getValue();
        $inventory = $spreadsheet->getCell('D18')->getValue();
        $trade_debtors = $spreadsheet->getCell('D19')->getValue();
        $cash_in_hand = $spreadsheet->getCell('D20')->getValue();
        $petty_cash  = $spreadsheet->getCell('D21')->getValue();
        $bank_account = $spreadsheet->getCell('D22')->getValue();
        $prepaid = $spreadsheet->getCell('D23')->getValue();
        $advance_commercial_tax = $spreadsheet->getCell('D24')->getValue();
        $adv_income_tax = $spreadsheet->getCell('D25')->getValue();
        $advance = $spreadsheet->getCell('D26')->getValue();
        $total_current_assets = $spreadsheet->getCell('D27')->getValue();
        $total_assets = $spreadsheet->getCell('D28')->getValue();
        $non_current_liabilities = $spreadsheet->getCell('D30')->getValue();
        $long_term_loan = $spreadsheet->getCell('D31')->getValue();
        $non_current_deferred_income = $spreadsheet->getCell('D32')->getValue();
        $deferred_tax = $spreadsheet->getCell('D33')->getValue();
        $total_non_current_liabilities = $spreadsheet->getCell('D34')->getValue();
        $current_liabilities = $spreadsheet->getCell('D36')->getValue();
        $trade_creditors = $spreadsheet->getCell('D38')->getValue();
        $current_deferred_income = $spreadsheet->getCell('D39')->getValue();
        $salary_payable = $spreadsheet->getCell('D40')->getValue();
        $internet_bill = $spreadsheet->getCell('D41')->getValue();
        $social_security_fees = $spreadsheet->getCell('D42')->getValue();
        $electricity_charges = $spreadsheet->getCell('D43')->getValue();
        $staff_fund = $spreadsheet->getCell('D44')->getValue();
        $bod_salaries = $spreadsheet->getCell('D45')->getValue();
        $consultant_salaries = $spreadsheet->getCell('D46')->getValue();
        $payable_stamp_duty = $spreadsheet->getCell('D47')->getValue();
        $payable_bonus = $spreadsheet->getCell('D48')->getValue();
        $bod_consultant_salaries_tax = $spreadsheet->getCell('D49')->getValue();
        $advance_2_and_5_percent_tax = $spreadsheet->getCell('D50')->getValue();
        $two_percent_tax = $spreadsheet->getCell('D51')->getValue();
        $five_percent_commercial_tax = $spreadsheet->getCell('D52')->getValue();
        $total_current_liabilities = $spreadsheet->getCell('D53')->getValue();
        $total_liabilities = $spreadsheet->getCell('D54')->getValue();
        $net_assets = $spreadsheet->getCell('D55')->getValue();
        $equity = $spreadsheet->getCell('D56')->getValue();
        $owner_shareholders_equity = $spreadsheet->getCell('D57')->getValue();
        $capital = $spreadsheet->getCell('D58')->getValue();
        $total_owner_shareholders_equity = $spreadsheet->getCell('D60')->getValue();
        $retained_earnings = $spreadsheet->getCell('D61')->getValue();
        $profit_loss_for_the_year = $spreadsheet->getCell('D62')->getValue();
        $profit_divided = $spreadsheet->getCell('D63')->getValue();
        $total_equity = $spreadsheet->getCell('D64')->getValue();

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
        $amount_2_data = $this->setData($excel_file);

        $this->validation($amount_2_data, $excel_file);

        $amount_2 = $this->model()->create($amount_2_data);
        return $amount_2->id;
    }
}
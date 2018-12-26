<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
@php 
    $i = 1;

@endphp
<head>
    <meta charset="UTF-8">
    <title>Document</title>

<style type="text/css">
    
    .custom-table{
        border-collapse: collapse;
        width: 80%;
        margin-top: 10px;
        color: black;
    }
    
    .custom-table th, .custom-table td {
        border: 1px solid black;
        padding: 5px;   
    }

    .invoice-css{
        margin-right: 100px;
        margin-left: 100px;
    }

    .terms-header{
        margin-right: 100px;
        margin-left: 100px;
    }

    .terms-p{
        margin-right: 100px;
        margin-left: 100px;
    }

    .heading-table{
        float: left;
        text-align: left;
        color: black;
    }

    .heading-table td{
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .heading-table1 {
        float: right;
        text-align: right;
        display: inline-block;
        color: black;
    }

    .heading-table1 td{
        padding-top: 5px;
        padding-bottom: 5px;
    }


    @media screen and (min-width: 300px) and (max-width: 500px){
            .invoice-css{
                margin-right: 5px;
                margin-left: 5px;
            }

            .custom-table{
                font-size: 8px;
                width: 50%;
            }

            .custom-table th, .custom-table td {
                border: 1px solid black;
                padding: 0px;   
            }
            
            .heading-table1 {
                float: left;
                text-align: left;
            }
            .heading-table {
                clear: left;
                
            }

            .heading-table1 td{
                
                font-size: 8px;
                padding-top: 0px;
                padding-bottom: 0px;
            }

            .heading-table td{
                font-size: 8px;
                padding-top: 0px;
                padding-bottom: 0px;
            }

            .terms-header{
                margin-right: 5px;
                margin-left: 5px;
                font-size: 10px;
            }

            .terms-p{
                margin-right: 5px;
                margin-left: 5px;
                font-size: 8px;
            }

        }
</style>
</head>
<body style="background-color: #5000C0; margin-left: 10px;margin-right: 10px;">
<img style="padding: 5px; margin-left: auto; margin-right: auto;display: block;"
     src="{{ env('DOMAIN_NAME') }}/image/acc.png" alt="">
    <div style="padding: 5px;background-color: white;margin-left: 5px;margin-right: 5px;margin-bottom: 5px;">
        <img style="margin-left: auto; margin-right: auto;display: block;" src="{{ env('DOMAIN_NAME') }}/image/quotation_invoice_receipt.png" align="center">
        
        <div class="invoice-css">
        <h4 style="text-align: center;font-size: 14px;">Invoice</h4>
        
        <table style="display: inline-block;" class="heading-table">
            <tr>
                <td>Customer ID</td>
                <td>:</td>
                <td>{{ $invoice['customer']['company_id'] }}</td>
            </tr>
            <tr>
                <td>Owner Name</td>
                <td>:</td>
                <td>{{ $invoice['customer']['owner_name'] }}</td>
            </tr>
            @if($invoice['receipt']['type'] == 'bank')
            <tr>
                <td>Bank</td>
                <td>:</td>
                <td>{{ $invoice['receipt']['bank'] }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>&nbsp;{{ date('d M Y', strtotime($invoice['receipt']['bank_date'])) }}</td>
            </tr>
            @else
            <tr>
                <td>Description</td>
                <td>:</td>
                <td>{{ $invoice['receipt']['description'] }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>&nbsp;{{ date('d M Y', strtotime($invoice['receipt']['cash_date'])) }}</td>
            </tr>
            @endif
            <tr>
                <td>Invoice Date</td>
                <td>:</td>
                <td style="color: blue;"><b>&nbsp;{{ date('d M Y', strtotime($invoice['created_at'])) }}</b></td>
            </tr>
            <tr>
                <td>Due Date</td>
                <td>:</td>
                <td style="color: red;"><b>&nbsp;{{ date('d M Y', strtotime('+ 7 day', strtotime($invoice['created_at']))) }}</b></td>
            </tr>
            <tr>
                <td>Receipt Date</td>
                <td>:</td>
                <td style="color: green;"><b>&nbsp;{{ date('d M Y', strtotime($invoice['receipt']['created_at'])) }}</b></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $invoice['customer']['email'] }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>:</td>
                <td>{{ $invoice['customer']['phone_no'] }}</td>
            </tr>
        </table>

        <table class="heading-table1">
            <tr>
                <td>Company Name</td>
                <td>:</td>
                <td>{{ $invoice['customer']['company_name'] }}</td>
            </tr>
            <tr>
                <td>Business Name</td>
                <td>:</td>
                <td>{{ $invoice['business']['business_name'] }}</td>
            </tr>
        </table>
        </div>
        <div>
        <table style=" padding: 3px !important;" class="custom-table" align="center">
            <tr>
                <th style="color: #270063;background-color: #EEEDED;">No</th>
                <th style="color: #270063;background-color: #EEEDED;">Service Type</th>
                <th style="color: #270063;background-color: #EEEDED;">Monthly</th>
                <th style="color: #270063;background-color: #EEEDED;">Yearly</th>
                <th style="color: #270063;background-color: #EEEDED;">Description</th>
                <th style="color: #270063;background-color: #EEEDED;">Amount(Ks)</th>
            </tr>

            @if(!empty($invoice['accounting_service']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Accounting Service</td>
                    
                    @if(!empty($invoice['accounting_service']['months']))
                    <td>{{ $invoice['accounting_service']['months'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    @if(!empty($invoice['accounting_service']['years']))
                    <td>{{ $invoice['accounting_service']['years'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">{{ number_format($invoice['accounting_service']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($invoice['auditing']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Auditing Service</td>
                    
                    @if(!empty($invoice['auditing']['months']))
                    <td>{{ $invoice['auditing']['months'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    @if(!empty($invoice['auditing']['years']))
                    <td>{{ $invoice['auditing']['years'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">{{ number_format($invoice['auditing']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($invoice['taxation']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Taxation Service</td>

                    @if(!empty($invoice['taxation']['months']))
                    <td>{{ $invoice['taxation']['months'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    @if(!empty($invoice['taxation']['years']))
                    <td>{{ $invoice['taxation']['years'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">{{ number_format($invoice['taxation']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($invoice['consulting']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Consulting Service</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td>{{ title_case(str_replace('_', ' ', $invoice['consulting']['license_type'])) }}</td>
                    <td style="text-align: right;">{{ number_format($invoice['consulting']['value']) }}</td>
                </tr>
            @endif
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Sub Total</td>
                <td style="text-align: right;">{{ number_format($invoice['sub_total']) }}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Discount</td>
                <td style="text-align: right;">{{ number_format($invoice['discount']) }}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Tax</td>
                <td style="text-align: right;">{{ number_format($invoice['tax']) }}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Total</td>
                <td style="text-align: right;">{{ number_format($invoice['total']) }}</td>
            </tr>
        </table>

        <h4 style="margin-top: 20px;font-size: 14px" class="terms-header"><b>Terms & Conditions</b></h4>

        <p style="font-size: 12px;color: black;" class="terms-p">
            1. Customer need to make payment before due date.<br>
            2. If payment is not paid before due date, business agreement will be cancel.<br>
            3. Customer need to send back scan copy of deposit slip to this email or Viber number:09254180009.</p>
        </div>
    </div>

    <div style="margin-left: auto; margin-right: auto;display: block; color: white;padding-bottom: 15px;text-align: center;">© 2018-2019, The Accountant Co.,Ltd.</div>
</body>
</html>

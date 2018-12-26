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

    .quotation-css{
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
            .quotation-css{
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
        
        <div class="quotation-css">
        <h4 style="text-align: center;font-size: 14px;">Quatation</h4>
        
        <table style="display: inline-block;" class="heading-table">
            <tr>
                <td>Customer ID</td>
                <td>:</td>
                <td>{{ $quotation['customer']['company_id'] }}</td>
            </tr>
            <tr>
                <td>Owner Name</td>
                <td>:</td>
                <td>{{ $quotation['customer']['owner_name'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $quotation['customer']['email'] }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>:</td>
                <td>{{ $quotation['customer']['phone_no'] }}</td>
            </tr>
        </table>

        <table class="heading-table1">
            <tr>
                <td>Company Name</td>
                <td>:</td>
                <td>{{ $quotation['customer']['company_name'] }}</td>
            </tr>
            <tr>
                <td>Business Name</td>
                <td>:</td>
                <td>{{ $quotation['business']['business_name'] }}</td>
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

            @if(!empty($quotation['accounting_service']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Accounting Service</td>
                    
                    @if(!empty($quotation['accounting_service']['months']))
                    <td>{{ $quotation['accounting_service']['months'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    @if(!empty($quotation['accounting_service']['years']))
                    <td>{{ $quotation['accounting_service']['years'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">{{ number_format($quotation['accounting_service']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($quotation['auditing']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Auditing Service</td>
                    
                    @if(!empty($quotation['auditing']['months']))
                    <td>{{ $quotation['auditing']['months'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    @if(!empty($quotation['auditing']['years']))
                    <td>{{ $quotation['auditing']['years'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">{{ number_format($quotation['auditing']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($quotation['taxation']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Taxation Service</td>

                    @if(!empty($quotation['taxation']['months']))
                    <td>{{ $quotation['taxation']['months'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    @if(!empty($quotation['taxation']['years']))
                    <td>{{ $quotation['taxation']['years'] }}</td>
                    @else
                    <td style="text-align: center;">-</td>
                    @endif
                    
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">{{ number_format($quotation['taxation']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($quotation['consulting']))
                <tr>
                    <td class="counterCell">{{ $i++ }}</td>
                    <td>Consulting Service</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td>{{ title_case(str_replace('_', ' ', $quotation['consulting']['license_type'])) }}</td>
                    <td style="text-align: right;">{{ number_format($quotation['consulting']['value']) }}</td>
                </tr>
            @endif
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Sub Total</td>
                <td style="text-align: right;">{{ number_format($quotation['sub_total']) }}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Discount</td>
                <td style="text-align: right;">{{ number_format($quotation['discount']) }}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="text-align: right;">Total</td>
                <td style="text-align: right;">{{ number_format($quotation['total']) }}</td>
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css">
    
    .custom-table {
        border-collapse: collapse;
    }

    .custom-table th, .custom-table td {
        border: 1px solid black;
        padding: 80px;
    }

    .heading-table td{
        padding-top: 5px;
        padding-bottom: 5px;
    }
    
    table {
        counter-reset: tableCount;
    }

    .counterCell:before {
        content: counter(tableCount);
        counter-increment: tableCount;
    }
    
    </style>
    </head>

<body style="background-color: #5000C0; margin: 50px;">
<img style="padding: 20px; display: block; margin-left: auto; margin-right: auto;"
     src="{{ env('DOMAIN_NAME') }}/image/acc.png" alt="">
<div style="padding: 10px; background-color: white;">
    <img style="padding: 3px;margin-left: auto; margin-right: auto;" src="{{ env('DOMAIN_NAME') }}/image/quotation_invoice_receipt.png" align="center">
    <div style="padding: 0px 50px 0px 50px;">
        <h2 style="text-align: center;font-size: 16px;">Quatation</h2>
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

        <table style="display: inline-block;float: right;text-align: right; " class="heading-table">
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

        <table style=" font-size: 12px; margin-top: 20px;" class="custom-table" align="center">
            <tr>
                <th style="color: #270063;background-color: lightgray;">No</th>
                <th style="color: #270063;background-color: lightgray;">Service Type</th>
                <th style="color: #270063;background-color: lightgray;">Monthly</th>
                <th style="color: #270063;background-color: lightgray;">Yearly</th>
                <th style="color: #270063;background-color: lightgray;">Service Type</th>
                <th style="color: #270063;background-color: lightgray;">Amount(Ks)</th>
            </tr>

            @if(!empty($quotation['accounting_service']))
                <tr>
                    <td class="counterCell"></td>
                    <td>Accounting Service</td>
                    <td>{{ $quotation['accounting_service']['months'] }}</td>
                    <td>{{ $quotation['accounting_service']['years'] }}</td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($quotation['accounting_service']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($quotation['auditing']))
                <tr>
                    <td class="counterCell"></td>
                    <td>Auditing Service</td>
                    <td>{{ $quotation['auditing']['months'] }}</td>
                    <td>{{ $quotation['auditing']['years'] }}</td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($quotation['auditing']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($quotation['taxation']))
                <tr>
                    <td class="counterCell"></td>
                    <td>Taxation Service</td>
                    <td>{{ $quotation['taxation']['months'] }}</td>
                    <td>{{ $quotation['taxation']['years'] }}</td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($quotation['taxation']['value']) }}</td>
                </tr>
            @endif
            @if(!empty($quotation['consulting']))
                <tr>
                    <td class="counterCell"></td>
                    <td>Consulting Service</td>
                    <td></td>
                    <td></td>
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

        <h4 style="margin-top: 20px;font-size: 16px"><b>Terms & Conditions</b></h4>

        <p style="font-size: 13px;">
            1. Customer need to make payment before due date.<br>
            2. If payment is not paid before due date, business agreement will be cancel.<br>
            3. Customer need to send back scan copy of deposit slip to this email or Viber number:09254180009.</p>
    </div>
   
    </div>
</body>
</html>

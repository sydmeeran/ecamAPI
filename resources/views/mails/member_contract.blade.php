<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Document</title></head>
<body style="background-color: #5000C0; margin: 0px 70px;">
<img style="padding: 20px; display: block; margin-left: auto; margin-right: auto;"
     src="{{ env('DOMAIN_NAME') }}/image/acc.png" alt="">
<div style="margin: 10px 40px; padding: 0px 3px 20px 3px; background-color: white;">
    <div style="padding: 0px 50px 0px 50px;">
        <p style="padding: 12px; margin: 0px 10px 20px 0px; font-size: 20px;">
            This message contains confidential information and is intended for the use of individual
            or entity to whom they are addressed.
            If you are not the intended recipient you are notified that disclosing,
            copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.
        </p>
    </div>

    <embed src="{{ env('DOMAIN_NAME') }}.'/'.{{ $message->embed($pdf) }}" />
</div>
<div style="margin: 10px 20px; padding: 30px 20px; background-color: #5000C0; color: #5000C0;">

</div>
</body>
</html>


{{--<div id="footbar" style="background:#441e1e;color:#FFF;font-size:12px;padding:12px;width:700px">Hot Line : 09-253027001,--}}

{{--+95 9 253027001-2<br>Address : No.(214/A), 4th Floor, Bo Aung Kyaw Street (Lower block), Botahtaung Township,--}}
{{--Yangon, Myanmar.--}}
{{--</div>--}}

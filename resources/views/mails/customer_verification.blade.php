<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Document</title></head>
<body style="background-color: #5000C0;">
<img style="padding: 20px; display: block; margin-left: auto; margin-right: auto;"
     src="{{ env('DOMAIN_NAME') }}/image/acc.png" alt="">
<div style="margin: 10px 40px; padding: 0px 40px 20px 40px; background-color: white;">
    <img style="padding: 3px" src="{{ env('DOMAIN_NAME') }}/image/customer_verification.jpg" alt="">
    <p style="padding: 12px; margin: 0px 10px 20px 0px; font-size: 20px;">
        We are excited to announce redesigned Cloudways,
        a new look that resonates more with our audience,
        along with the enhancements in Staging,
        a new Let’s Encrypt Wildcard SSL feature,
        an empowering Startup Program, and more.
    </p>
    <form action="{{ env('APP_URL') }}/api/customers/use" method="POST">
        @csrf
        <input type="hidden" name="otp" value="{{ $otp }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="submit" style="
                display: block; margin: 0 auto;
                color: #5000C0; background-color: #00EBB3;
              border: none;
              padding: 15px 32px;
              text-align: center;
              text-decoration: none;
              font-size: 16px;
        " value="Verify Account">
    </form>
</div>
<div style="margin: 10px 20px; padding: 0px 20px; background-color: #5000C0; color: #5000C0;">
    We are excited to announce redesigned Cloudways,
    a new look that resonates more with our audience,
    along with the enhancements in Staging,
    a new Let’s Encrypt Wildcard SSL feature,
    an empowering Startup Program, and more.
</div>
</body>
</html>


{{--<div id="footbar" style="background:#441e1e;color:#FFF;font-size:12px;padding:12px;width:700px">Hot Line : 09-253027001,--}}

{{--+95 9 253027001-2<br>Address : No.(214/A), 4th Floor, Bo Aung Kyaw Street (Lower block), Botahtaung Township,--}}
{{--Yangon, Myanmar.--}}
{{--</div>--}}

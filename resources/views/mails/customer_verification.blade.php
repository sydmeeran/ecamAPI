<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Document</title></head>
<body>
<style></style>
<div id="wrapper" style="border:2px solid #441e1e;font-size:13px;letter-spacing:1px;padding:10px;width:700px">
    <div id="logo" style="font-size:20px"><p>
            {{--<img src="http://aweltaw.com/img/awt_logo.png"--}}
                                                  {{--width="100px;" alt="">--}}
            <u style="padding-left:80px">Accountant</u></p></div>
    <h2>မင်္ဂလာပါ {{ $name }}</h2>
    <p>လူကြီးမင်း၏ Account အားမှတ်ပုံတင်ပြီးဖြစ်ပါသည်။<br>သင့်၏ email မှန်ကန်ကြောင်း အတည်ပြုရန် အောက်တွင်ပါရှိသော button
        အားနှိုပ်ပါ။</p>
    <form action="{{ env('APP_URL') }}/api/customers/verification" method="POST">
        @csrf
        <input type="text" name="code" style="display: none;" value="{{ $code }}">
        <input type="email" name="email" style="display: none;" value="{{ $email }}">
        <input type="submit" style="color: white; background-color: green;" value="Verify Account">
    </form>
    <p>ကျေးဇူးအထူးတင်ရှိပါသည်။</p>

    <div id="zawgyi" style="border-left:2px solid #441e1e;padding:20px"><h2>မဂၤလာပါ {{ $name }}</h2>
        <p>လူႀကီးမင္း၏ Account အားမှတ္ပံုတင္ၿပီးျဖစ္ပါသည္။<br>သင့္၏ email မွန္ကန္ေၾကာင္း အတည္ျပဳရန္ ေအာက္တြင္ပါရွိေသာ
            button အားႏႈိပ္ပါ။</p>
        <p>ေက်းဇူးအထူးတင္ရွိပါသည္။</p></div>
    <form action="{{ env('APP_URL') }}/api/customers/verification" method="POST">
        @csrf
        <input type="text" name="code" style="display: none;" value="{{ $code }}">
        <input type="email" name="email" style="display: none;" value="{{ $email }}">
        <input type="submit" style="color: white; background-color: green;" value="Verify Account">
    </form>
</div>
<div id="footbar" style="background:#441e1e;color:#FFF;font-size:12px;padding:12px;width:700px">Hot Line : 09-253027001,

    +95 9 253027001-2<br>Address : No.(214/A), 4th Floor, Bo Aung Kyaw Street (Lower block), Botahtaung Township,
    Yangon, Myanmar.
</div>
</body>
</html>

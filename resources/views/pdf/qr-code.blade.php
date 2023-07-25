<html>

<head>
</head>
<style>
    @page {
        margin: 0;
        font-family: "Times New Roman", Times, serif;
    }

    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    #qrcode {
        height: 0.9cm;
        width: 0.9cm;
    }

    #logo {
        width: 1cm;
    }

    .container-qr {
        text-align: center;
        display: block;
        margin-top: -3px;
    }

    .template-qr {
        align-content: center;
        border: 0.5px solid #000;
        height: 1.4cm;
        width: 1.4cm;
        padding: 3px;
        margin-right: -5px;
        margin-top: 3mm;
        text-align: center;
        display: inline-block;
    }

    .container {
        width: 9.4cm;
        height: 1.5cm;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body>
    <div class="container">
        @for ($i = 0; $i < $count; $i++) <div class="template-qr">
            <img id="logo" src="{{ public_path('/assets/img/logo-dexa.png') }}">
            <div class="container-qr" id="qr">
                <img id="qrcode" src="data:image/png;base64, {!! base64_encode($qrcode) !!}">
            </div>
            <br>
            <br>
    </div>
    @endfor
    </div>
</body>

</html>
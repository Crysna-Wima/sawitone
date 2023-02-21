<html>

<head>
</head>
<style>
    @page {
        margin: 40px 40px;
        font-family: "Times New Roman", Times, serif;
    }

    * {
        font-family: Arial, Helvetica, sans-serif;
    }


    p,
    label {
        font-size: 12px;
    }

    table {
        font-size: 11px;
    }

    table th {
        padding: 6px 4px;
        font-size: .8rem;
    }

    table td {
        padding: 6px 4px;
        font-size: .8rem;
    }

    .tp-1 td{
        padding: 9px 4px!important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .table-header {
        font-size: 11px;
    }

    .next-page {
        page-break-before: always;
    }

    .no-margin>* {
        margin: 0 !important;
    }

    .header-text p {
        margin-bottom: 0px;
    }

    .table-success th {
        background: rgb(204, 255, 204) !important;
    }

    .image-container {
        margin: auto;
        width: 100%;
        position: relative;
        justify-content: center;
        flex-direction: column;
    }

    .background-header{
        height: 350px;
        background-size: 100% auto;
        bottom: 0;
        position: absolute;
        width: 100%;
        background-repeat: no-repeat;
        background-image: url({{ public_path('assets-pdf/bg.jpg') }})
    }

    .container {
        width: 100%;
        margin: auto;
    }

    .daftar_isi li {
        padding: 8px 0 0 5px !important;
    }

    .table-lg td{
        font-size: .8rem!important;
    }

    .table-xl td {
        font-size: .9rem !important;
    }

    .div-lg p{
        font-size: .9rem!important;
    }

    .fw-bold{
        font-weight: bold;
        white-space: nowrap;
    }

    th,
    td {
        vertical-align: middle;
    }

    .table-center thead tr th, .table-center tbody tr td{
        text-align: center;
    }

    .table-start thead tr th, .table-start tbody tr td{
        vertical-align: start;
    }

    .table-center-start thead tr th{
        vertical-align: center;
        text-align: center;
    }

    .table-center-start tbody tr td{
        vertical-align: start;
    }

    .text-start{
        text-align: unset!important;
    }

    .pl-2{
        padding-left: 75px;
    }

    .pl-1{
        padding-left: 50px;
    }

    .pl-0{
        padding-left: 25px;
    }

    .header{
        width: 100%;
    }

    .content{
        margin-top: 25px
    }

    .pt-1 > * {
        padding-top: 15px;
    }

    .pb-1 > *{
        padding-bottom: 15px;
    }

    .content p {
        font-size: .8rem!important;
    }

</style>

<body>
<div class="container" id="so-pdf">
    <div class="header" style="height: 100px">
        <div style="position: absolute; left: 0; top: 0">
            <img src="{{ public_path('/assets/img/logo-dexa.png') }}" width="35%">
        </div>
        <div style="position: absolute; right: 0; top: 10px; text-align: right;" class="no-margin">
            <p><b>PT DEXA ARFINDO PRATAMA</b></p>
            <p>Jl. Raya Jemursari No.329-331, Sidosermo, Kec. Wonocolo</p>
            <p>Surabaya, Jawa Timur (60297)</p>
            <p><b>dexa-arfindopratama.com</b></p>
        </div>
    </div>
</div>

<div class="content">
        <p style="text-align: center; font-weight:bold">Delivery Order</p>
        <p style="text-align: center">({{ $do_mst->fc_dono }})</p>

        <table style="width: 90%; border-collapse: collapse; margin: auto; border-bottom: 1px dashed black;" class="no-space">
            <tr class="tp-1">
                <td>Tanggal Order</td>
                <td style="width: 5px"> :</td>
                <td style="width: 28%">{{ \Carbon\Carbon::parse( $do_mst->created_at )->isoFormat('D MMMM Y'); }}</td>
                <td>No. Order</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">{{ $do_mst->fc_sono }}</td>
            </tr>
            <tr class="tp-1">
                <td>Tanggal Expired</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">{{ \Carbon\Carbon::parse( $do_mst->somst->fd_soexpired )->isoFormat('D MMMM Y'); }}</td>
            </tr>
            <tr class="tp-1 pb-1">
                <td>Tanggal Delivery</td>
                <td style="width: 5px">:</td>
                <td>{{ $do_mst->fd_dodateinputuser }}</td>
                <td></td><td></td><td></td>
            </tr>
        </table>

        <p style="font-weight: bold; font-size: .8rem; margin-left: 5%">{{ $do_mst->fc_sotype }}</p>
        <table style="width: 90%; border-collapse: collapse; margin: auto; border-bottom: 1px dashed black;" class="no-space">
 
        </table>

        <table style="width: 90%; border-collapse: collapse; margin: auto; dashed black; cellspacing=15 ">
            <br><br/>
            <tr>
                <td style="text-align: right;">Sales Operator, PT. DEXA ARFINDO PRATAMA</td>
            </tr>
            <br><br/>
            <br><br/>
            <tr >
                <td style="text-align: right;">(..............................)</td>
            </tr>
        </table>
    <div>
</body>

</html>

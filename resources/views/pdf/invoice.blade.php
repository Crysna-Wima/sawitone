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
        <div style="position: absolute; left: 30; top: 110px; text-align: left;" class="no-margin">
            <p><b>Kepada Yth</b></p>
            <p>{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</p>
            <p>{{ $do_mst->somst->customer->fc_memberaddress_loading1 }}</p>
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
        <br><br><br>
        <p style="text-align: center; font-weight:bold">INVOICE</p>
        <br>
        <table style="width: 90%; border-collapse: collapse; margin: auto;" class="no-space">
            <tr>
                <td>NPWP</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $do_mst->somst->customer->fc_membernpwp_no ?? '-' }}</td>
                <td>Tanggal</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->fd_inv_releasedate )->isoFormat('D MMMM Y'); }}</td>
            </tr>
            <tr class="pb-1">
                <td>Nomor</td>
                <td style="width: 5px">:</td>
                <td style="width: 30%">{{ $inv_mst->fc_invno }}</td>
                <td>Jatuh Tempo</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">{{ \Carbon\Carbon::parse( $inv_mst->fd_inv_agingdate )->isoFormat('D MMMM Y'); }}</td>
            </tr>
        </table>

        <table class="table-lg table-center" style="margin-bottom: 25px; margin-top: 15px; border-collapse: collapse; width: 100%" border="1">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Unity</th>
                <th>Qty</th>
                <th>Harga (Rp)</th>
                <th>Diskon (Rp)</th>
                <th>Total (Rp)</th>
            </tr>

            @if(isset($do_dtl))
                @foreach ($do_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->invstore->stock->fc_namelong }}</td>
                        <td>{{ $item->invstore->stock->fc_namepack }}</td>
                        <td>{{ $item->fn_qty_do }}</td>
                        <td>{{ $item->fn_price }}</td>
                        <td>{{ $item->fn_disc }}</td>
                        <td>{{ $item->fn_value }}</td>
                    </tr>
                @endforeach

            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif

        </table>

        <table style="width: 90%; border-collapse: collapse; margin: auto; border-bottom: 1px dashed black;">
            <tr class="pt-1">
                <td>Item</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">{{  $do_mst->fn_dodetail }}</td>
                <td>Biaya Service</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format( $do_mst->somst->fm_servpay,0,',','.')}}</td>
            </tr>

            <tr>
                <td>Diskon Total</td>
                <td style="width: 5px">:</td>
                <td style="width: 28%">Rp. {{ number_format($do_mst->somst->fm_disctotal,0,',','.')}}</td>
                <td>Pajak</td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format($do_mst->somst->fm_tax,0,',','.')}}</td>
            </tr>
            <tr class="pb-1">
                <td></td>
                <td style="width: 5px"></td>
                <td style="width: 28%"></td>
                <td><b>Tagihan</b></td>
                <td style="width: 5px">:</td>
                <td style="width: 26%">Rp. {{ number_format($do_mst->somst->fm_brutto,0,',','.')}}</td>
            </tr>
        </table>

        <table style="width: 100%;   margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always">
            <br><br/>
            <tr>
                <td style="text-align: right;">Surabaya, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y'); }}</td>
            </tr>
        </table>
        <table style="width: 100%; margin: auto; dashed black; cellspacing=15 page-break-before:always page-break-after:always ">
            <br>
            <tr >
                <td style="width: 50% !important; text-align: left;">Send By,</td>
                <td style="width: 50% !important; text-align: right;">Received By,</td>
            </tr>
            <tr>
                <td style="width: 50% !important; text-align: left;">PT DEXA ARFINDO PRATAMA</td>
                <td style="width: 50% !important; text-align: right;">{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</td>
            </tr>
            <br><br/>
            <br><br/>
            <tr >
                <td style="width: 50% !important; text-align: left;">(..................................................)</td>
                <td style="width: 50% !important; text-align: right;">(..................................................)</td>
            </tr>
        </table>
    <div>
</body>

</html>

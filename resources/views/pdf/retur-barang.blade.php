<html>

<head>
<title>Retur Barang</title>
<link href="https://www.dafontfree.net/embed/bHVjaWRhLWNvbnNvbGUtcmVndWxhciZkYXRhLzExL2wvNjAzODMvTHVjaWRhIENvbnNvbGUudHRm" rel="stylesheet" type="text/css" />
</head>
<style>
    @page {
        size: 8.5in 11in;
        margin: 40px 40px;
        font-family: 'lucida-console-regular', sans-serif;
    }

    * {
        font-family: 'lucida-console-regular', sans-serif;
    }


    p,
    label {
        font-size: 15px;
    }

    table {
        font-size: 15px;
    }

    table th {
        padding: 6px 4px;
        font-size: 16px;
        font-weight: regular;
        font-family: 'lucida-console-regular', sans-serif;
    }

    table td {
        padding: 6px 4px;
        font-size: 15px!important;
    }

    .tp-1 td{
        padding: 9px 4px!important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .table-header {
        font-size: 15px!important;
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
        font-size: 15px!important;
    }

    .table-xl td {
        font-size: 15px!important;
    }

    .div-lg p{
        font-size: 15px!important;
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

    #watermark {
        position: fixed;
        top: 25%;
        width: 100%;
        text-align: center;
        opacity: .5;
        transform-origin: 50% 50%;
        z-index: -1000;
    }

    .table-lg,
    .table-lg th,
    .table-lg td {
        border: 2px solid black;
    }

    @media print {
        html,
        body {
            width: 8.5in;
            height: 11in;
            display: block;
            font-family: 'lucida-console-regular', sans-serif;
        }

        @page {
            size: 8.5in 11in;
        }
    }
</style>

@for ($i = 0; $i < 3; $i++)
<body>
    <main>
    <div class="container" id="print">
    <div class="header" style="height: 100px">
        <div style="position: absolute; right: 0px; top: 0; text-align: left;" class="no-margin">
        @if ($i == 0)
            <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">ASLI</p>
        @elseif ($i == 1)
            <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">COPY 1</p>
        @else
            <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">COPY 2</p>
        @endif
        </div>
        <div style="position: absolute; left: 0; top: 30; text-align: left;" class="no-margin">
            <p style="font-size: 16px;">PT DEXA ARFINDO PRATAMA</p>
            <p>Jl. Raya Jemursari No.329-331,</p>
            <p>Sidosermo, Kec. Wonocolo,</p>
            <p>Surabaya, Jawa Timur (60297)</p>
            <p>dexa-arfindopratama.com</p>
            <br>
            <p style="font-size: 16px;">Kepada</p>
            <p>{{ $retur_mst->domst->somst->customer->fc_memberlegalstatus }} {{ $retur_mst->domst->somst->customer->fc_membername1 }}</p>
            <p style="font-size: 16px;">Alamat Pengiriman</p>
            <p>{{ $retur_mst->domst->somst->customer->fc_memberaddress_loading1 }}</p>
        </div>
        <div style="position: absolute; right: 0px; top: 30; text-align: left;" class="no-margin">
            <p style="font-size: 16px;">RETUR BARANG</p>
            <p>No. Retur &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $retur_mst->fc_returno }}</p>
            <p>Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ \Carbon\Carbon::parse( $retur_mst->fd_returdate )->isoFormat('D MMMM Y'); }}</p>
            <p>No. DO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $retur_mst->fc_dono }}</p>
        </div>
    </div>
</div>

<div class="content" id="print">
    <br><br>
    <br><br>
    <br><br>
    <br>
        <p style="font-size: 16px;">Barang yang Diretur</p>
        <table class="table-lg table-center" style="margin-bottom: 15px; border-collapse: collapse; width: 100%;" border="1">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Batch</th>
                <th>Expired Date</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
            </tr>

            @if(isset($retur_dtl))
                @foreach ($retur_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
                        <td>{{ $item->invstore->stock->fc_namelong }}</td>
                        <td>{{ $item->fc_batch }}</td>
                        <td>{{ \Carbon\Carbon::parse( $item->fd_expired )->isoFormat('D MMMM Y'); }}</td>
                        <td>{{ $item->fn_returqty }} {{ $item->invstore->stock->fc_namepack }}</td>
                        <td>Rp. {{ number_format($item->fn_price,0,',','.')}}</td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="12" class="text-center">Data Not Found</td>
            </tr>
            @endif
        </table>
        
        <br><br>
        <table style="width: 100%; margin: auto; dashed black; cellspacing=15 ">
            <br>
            <tr >
                <td style="width: 50% !important; text-align: left;">Dikirim Oleh,</td>
                <td style="width: 50% !important; text-align: right;">Diterima Oleh,</td>
            </tr>
            <tr>
                <td style="width: 50% !important; text-align: left;">PT DEXA ARFINDO PRATAMA</td>
                <td style="width: 50% !important; text-align: right;">{{ $retur_mst->domst->somst->customer->fc_memberlegalstatus }} {{ $retur_mst->domst->somst->customer->fc_membername1 }}</td>
            </tr>
            <br><br/>
            <br><br/>
            <tr >
                <td style="width: 50% !important; text-align: left;">({{ $nama_pj }})</td>
                <td style="width: 50% !important; text-align: right;">(......................)</td>
            </tr>
        </table>
    <div>
    </main>
</body>
@endfor

</html>
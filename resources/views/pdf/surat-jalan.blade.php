<html>

<head>
</head>
<style>
    @page {
        margin: 40px 40px;
        font-family: 'Roboto Mono', monospace;
    }

    * {
        font-family: 'Roboto Mono', monospace;
    }


    p,
    label {
        font-size: 16px!important;
    }

    table {
        font-size: 16px;
    }

    table th {
        padding: 6px 4px;
        font-size: 16px!important;
    }

    table td {
        padding: 6px 4px;
        font-size: 16px!important;
    }

    .tp-1 td{
        padding: 9px 4px!important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .table-header {
        font-size: 16px!important;
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
        font-size: 16px!important;
    }

    .table-xl td {
        font-size: 16px!important;
    }

    .div-lg p{
        font-size: 16px!important;
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
</style>

<body>
    <?php if($do_mst->fc_dostatus == 'CC'): ?>
        <div id="watermark"><img src="{{ public_path('/assets/img/cancelled.png') }}" width="45%"></div>
    <?php endif; ?>
    <main>
    <div class="container" id="sj-pdf">
    <div class="header" style="height: 100px">
        <div style="position: absolute; left: 0; top: 0; text-align: left;" class="no-margin">
            <p><b>PT DEXA ARFINDO PRATAMA</b></p>
            <p>Jl. Raya Jemursari No.329-331,</p>
            <p>Sidosermo, Kec. Wonocolo,</p>
            <p>Surabaya, Jawa Timur (60297)</p>
            <p><b>dexa-arfindopratama.com</b></p>
            <br>
            <p><b>Kepada</b></p>
            <p>{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</p>
            <p><b>Alamat Pengiriman</b></p>
            <p>{{ $do_mst->somst->customer->fc_memberaddress_loading1 }}</p>
        </div>
        <div style="position: absolute; right: 0px; top: 0; text-align: left;" class="no-margin">
            <p><b>SURAT JALAN</b></p>
            <p>No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $do_mst->fc_dono }}</p>
            <p>Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ \Carbon\Carbon::parse( $do_mst->fd_dodate )->isoFormat('D MMMM Y'); }}</p>
            <p>No. SO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $do_mst->fc_sono }}</p>
        </div>
    </div>
</div>

<div class="content">
    <br><br>
    <br><br>
        <p style="font-weight: bold; font-size: 18px;">Pengiriman Barang</p>
        <table class="table-lg table-center" style="margin-bottom: 15px; border-collapse: collapse; width: 100%;" border="1">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Batch</th>
                <th>Expired Date</th>
                <th>Jumlah</th>
            </tr>

            @if(isset($do_dtl))
                @foreach ($do_dtl as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->invstore->stock->fc_stockcode }}</td>
                        <td>{{ $item->invstore->stock->fc_namelong }}</td>
                        <td>{{ $item->fc_batch }}</td>
                        <td>{{ \Carbon\Carbon::parse( $item->fd_expired )->isoFormat('D MMMM Y'); }}</td>
                        <td>{{ $item->fn_qty_do }} {{ $item->invstore->stock->fc_namepack }}</td>
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
                <td style="width: 50% !important; text-align: right;">{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</td>
            </tr>
            <br><br/>
            <br><br/>
            <tr >
                <td style="width: 50% !important; text-align: left;">(......................)</td>
                <td style="width: 50% !important; text-align: right;">(......................)</td>
            </tr>
        </table>
    <div>
    </main>
</body>

</html>
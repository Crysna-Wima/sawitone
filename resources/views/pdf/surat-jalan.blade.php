<html>

<head>
<title>Surat Jalan</title>
    <link href="https://www.dafontfree.net/embed/bHVjaWRhLWNvbnNvbGUtcmVndWxhciZkYXRhLzExL2wvNjAzODMvTHVjaWRhIENvbnNvbGUudHRm" rel="stylesheet" type="text/css" />
</head>
<style>
    @page {
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
        font-size: 15px;
    }

    .tp-1 td {
        padding: 9px 4px !important;
    }

    .no-space td {
        padding: 2px 6px;
        margin: 0;
    }

    .table-header {
        font-size: 15px;
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

    .container {
        width: 100%;
        margin: auto;
    }

    .daftar_isi li {
        padding: 8px 0 0 5px !important;
    }

    .table-lg td {
        font-size: 15px;
    }

    .table-xl td {
        font-size: 15px;
    }

    .div-lg p {
        font-size: 15px;
    }

    th,
    td {
        vertical-align: middle;
    }

    .table-center thead tr th,
    .table-center tbody tr td {
        text-align: center;
    }

    .table-start thead tr th,
    .table-start tbody tr td {
        vertical-align: start;
    }

    .table-center-start thead tr th {
        vertical-align: center;
        text-align: center;
    }

    .table-center-start tbody tr td {
        vertical-align: start;
    }

    .text-start {
        text-align: unset !important;
    }

    .pl-2 {
        padding-left: 75px;
    }

    .pl-1 {
        padding-left: 50px;
    }

    .pl-0 {
        padding-left: 25px;
    }

    .header {
        width: 100%;
    }

    .content {
        margin-top: 25px
    }

    .pt-1>* {
        padding-top: 15px;
    }

    .pb-1>* {
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

    .kotak {
        border: 0.5px solid #000;
        height: 0.6cm;
        width: 1cm;
        padding: 2px;
    }
</style>

@for ($i = 0; $i < 5; $i++)
<body>
    <?php if ($do_mst->fc_dostatus == 'CC') : ?>
        <div id="watermark"><img src="{{ public_path('/assets/img/cancelled.png') }}" width="45%"></div>
    <?php endif; ?>
    <main>
        <div class="container" id="print">
            <div class="header" style="height: 100px">
                <div style="position: absolute; right: 0px; top: 0; text-align: left;" class="no-margin">
                @if ($i == 0)
                    <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">ASLI</p>
                @elseif ($i == 1)
                    <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">COPY 1</p>
                @elseif ($i == 2)
                    <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">COPY 2</p>
                @elseif ($i == 3)
                    <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">COPY 3</p>
                @else
                    <p style="font-size: 16px; font-weight: bold; border: 0.5px solid #000; padding: 8px;">COPY 4</p>
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
                    <p>{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</p>
                    <p style="font-size: 16px;">Alamat Pengiriman</p>
                    <p>{{ $do_mst->somst->customer->fc_memberaddress_loading1 }}</p>
                </div>
                <div style="position: absolute; right: 0px; top: 30; text-align: left;" class="no-margin">
                    <p style="font-size: 16px;">SURAT JALAN</p>
                    <p>No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $do_mst->fc_dono }}</p>
                    <p>Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ \Carbon\Carbon::parse( $do_mst->fd_dodate )->isoFormat('D MMMM Y'); }}</p>
                    <p>No. SO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $do_mst->fc_sono }}</p>
                </div>
            </div>
        </div>

        <div class="content" id="print">
            <br><br>
            <br><br>
            <br><br>
            <br>
            <p style="font-size: 16px;">Pengiriman Barang</p>
            <table class="table-lg table-center" style="font-family: 'lucida-console-regular', sans-serif; margin-bottom: 15px; border-collapse: collapse; width: 100%;" border="1">
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
                <tr>
                    <td style="width: 50% !important; text-align: left;">Dikirim Oleh,</td>
                    <td style="width: 50% !important; text-align: right;">Diterima Oleh,</td>
                </tr>
                <tr>
                    <td style="width: 50% !important; text-align: left;">PT DEXA ARFINDO PRATAMA</td>
                    <td style="width: 50% !important; text-align: right;">{{ $do_mst->somst->customer->fc_memberlegalstatus }} {{ $do_mst->somst->customer->fc_membername1 }}</td>
                </tr>
                <tr>
                    <td style="width: 50% !important; text-align: left;"><br><br></td>
                    <td style="width: 50% !important; text-align: right;">            
                    @if ($i == 0)
                        <br><br>
                        <br><br>
                    @elseif ($user->fv_ttdpath == null)
                        <br><br>
                        <br><br>
                    @else
                        <img src="{{ $user->fv_ttdpath }}" alt="" width="120" height="120">
                    @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 50% !important; text-align: left;">(......................)</td>
                    <td style="width: 50% !important; text-align: right;">( {{ $nama_pj }} )</td>
                </tr>
            </table>
            <div>
    </main>
</body>
@endfor

</html>
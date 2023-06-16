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

    .container{
        /* border: 0.5px solid #000; */
        /* margin-bottom: 20px; */
        page-break-inside: avoid;
    }
</style>

<body>
    @for ($i = 1; $i < $count+1; $i++)
    <div class="container">
        <p style="text-align: center; font-weight:bold; font-size:15px;">TRANSIT BARANG</p>
        <table style="width: 40%; border-collapse: collapse; margin: auto;" class="no-space">
            <tr>
                <td><b>Tgl Diterima</b></td>
                <td style="width: 5px">:</td>
                <td style="width: 20%">{{ \Carbon\Carbon::parse( $gr_mst->fd_arrivaldate )->isoFormat('D MMMM Y'); }}</td>
            </tr>
            <tr>
                <td><b>No. Surat</b></td>
                <td style="width: 5px">:</td>
                <td style="width: 20%">{{ $gr_mst->fc_grno }}</td>
            </tr>
            <tr>
                <td><b>Dikirim Oleh</b></td>
                <td style="width: 5px">:</td>
                <td style="width: 20%">{{ $gr_mst->supplier->fc_supplierlegalstatus }} {{ $gr_mst->supplier->fc_suppliername1 }}</td>
            </tr>
            <tr>
                <td><b>Jumlah Koli</b></td>
                <td style="width: 5px">:</td>
                <td style="width: 20%">{{ $gr_mst->fn_qtyitem }}</td>
            </tr>
        </table>
        <p style="text-align: center; font-weight:bold; font-size:64px; margin:5px;">{{ $i }}/{{ $count }}</p>
        <br>
    </div>
    @endfor
</body>

</html>
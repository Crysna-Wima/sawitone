<html>

<head>
</head>
<style>
    @page {
        font-family: "Times New Roman", Times, serif;
        margin:0px;
    }

    * {
        font-family: Arial, Helvetica, sans-serif;
    }
    .container{
        height: 300px;
        margin:0px;
    }
    td{
        font-size: 20px;
    }
</style>

<body>
    @for ($i = 1; $i < $count+1; $i++)
    <div class="container" style="page-break-inside: avoid;">
        <p style="text-align: center; font-weight:bold; font-size:25px;">TRANSIT BARANG</p>
        <table style="width: 100%; border-collapse: collapse;" class="no-space">
            <tr>
                <td style="width: 45%;"><b>Tgl Diterima</b></td>
                <td style="width: 10; text-align:center" >:</td>
                <td style="width: 45%">{{ \Carbon\Carbon::parse( $gr_mst->fd_arrivaldate )->isoFormat('D MMMM Y'); }}</td>
            </tr>
            <tr>
                <td style="width: 45%;"><b>No. Surat</b></td>
                <td style="width: 10%; text-align:center">:</td>
                <td style="width: 45%">{{ $gr_mst->fc_grno }}</td>
            </tr>
            <tr>
                <td style="width: 45%;"><b>Dikirim Oleh</b></td>
                <td style="width: 10%; text-align:center">:</td>
                <td style="width: 45%">{{ $gr_mst->supplier->fc_supplierlegalstatus }} {{ $gr_mst->supplier->fc_suppliername1 }}</td>
            </tr>
            <tr>
                <td style="width: 45%;"><b>Jumlah Koli</b></td>
                <td style="width: 10%; text-align:center" >:</td>
                <td style="width: 45%">{{ $gr_mst->fn_qtyitem }}</td>
            </tr>
        </table>
        <p style="text-align: center; font-weight:bold; font-size:64px; margin:5px;">{{ $i }}/{{ $count }}</p>
        <br>
    </div>
    @endfor
</body>

</html>
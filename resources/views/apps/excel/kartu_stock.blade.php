<!DOCTYPE html>
<html>
<head>
<style>
    body {
        padding: 20px;
    }
    table {
        border-collapse: collapse;
        width: 790px;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th rowspan="2" style="border: 2px solid black;">Range Waktu</th>
            <th rowspan="2" style="border: 2px solid black;">Nama Gudang</th>
            <th rowspan="2" style="border: 2px solid black;">Nama Stock + Katalog</th>
            <th colspan="3" style="border: 2px solid black;">Riwayat Inquiri</th>
        </tr>
        <tr>
            <th style="border: 2px solid black;">Date</th>
            <th style="border: 2px solid black;">In/Out</th>
            <th style="border: 2px solid black;">Reference</th>
            <th style="border: 2px solid black;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kartu_stock as $stock)
        <tr>
            <td style="border: 2px solid black;">{{ $range_date }}</td>
            <td style="border: 2px solid black;">{{ $stock->warehouse->fc_rackname }}</td>
            <td style="border: 2px solid black;">{{ $stock->invstore->stock->fc_namelong}}</td>
            <td style="border: 2px solid black;">{{ $stock->fd_inqdate }}</td>
            <td style="border: 2px solid black;">{{ $stock->fn_in }} / {{ $stock->fn_out }}</td>
            <td style="border: 2px solid black;">{{ $stock->fc_docreference }}</td>
            <td style="border: 2px solid black;">{{ $stock->fv_description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

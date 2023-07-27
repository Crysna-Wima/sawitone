<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Sales Order Pending</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">No</th>
                <th style="text-align: center; font-weight: bold">No. SO</th>
                <th style="text-align: center; font-weight: bold">Tanggal</th>
                <th style="text-align: center; font-weight: bold">Expired</th>
                <th style="text-align: center; font-weight: bold">Tipe</th>
                <th style="text-align: center; font-weight: bold">Operator</th>
                <th style="text-align: center; font-weight: bold">Customer</th>
                <th style="text-align: center; font-weight: bold">Item</th>
                <th style="text-align: center; font-weight: bold">Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- no urut --}}
            @php $i = 1; @endphp
            @foreach($masterSoPending as $data)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $data->fc_sono }}</td>
                    <td>{{ $data->fd_sodatesysinput }}</td>
                    <td>{{ $data->fd_soexpired }}</td>
                    <td>{{ $data->fc_sotype }}</td>
                    <td>{{ $data->fc_userid }}</td>
                    <td>{{ $data->customer->fc_membername1 }}</td>
                    <td>{{ $data->fn_sodetail }}</td>
                    <td>Rp. {{ number_format($data->fm_brutto,0,',','.')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
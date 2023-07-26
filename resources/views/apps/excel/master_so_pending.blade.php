<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master Sales Order Pending</title>
</head>
<body>
    <h1>Master Sales Order Pending</h1>
    <table>
        <thead>
            <tr>
                <th scope="col" class="text-center">No</th>
                <th scope="col" class="text-center">No. SO</th>
                <th scope="col" class="text-center">Tanggal</th>
                <th scope="col" class="text-center">Expired</th>
                <th scope="col" class="text-center">Tipe</th>
                <th scope="col" class="text-center">Customer</th>
                <th scope="col" class="text-center">Item</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Total</th>
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
                    <td>{{ $data->customer->fc_membername1 }}</td>
                    <td>{{ $data->fn_sodetail }}</td>
                    <td>{{ $data->fc_sostatus }}</td>
                    <td>{{ $data->fm_brutto }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>